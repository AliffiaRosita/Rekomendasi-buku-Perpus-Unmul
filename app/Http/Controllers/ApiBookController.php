<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use App\Recommend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApiBookController extends Controller
{
    public function getBook()
    {
        $books = Book::paginate(10);
        $books->getCollection()->transform(function($value){
            if(empty($value->foto)){
                $foto = null;
            }else{
                $foto= url('image/buku/'.$value->foto);
            }
            return [
                'id_buku'=> $value->id,
                'judul'=>$value->judul,
                'penerbit'=> $value->penerbit,
                'isbn'=>$value->isbn,
                'tempat_terbit'=> $value->tempat_terbit,
                'foto'=>$foto
            ];
        });

        return response()->json($books,200);
    }

    public function detailBook($id)
    {
        $visitorId = Auth::user()->visitor->id; //nanti diganti pake visitor yg ada di login
        $books = Book::findOrFail($id);
        $average = Rating::join('buku','rating.buku_id','=','buku.id')
                ->where('buku_id', $id)
                ->selectRaw('avg(nilai) as rata')
                ->groupBy('buku_id')
                ->get();
        $ratings = Rating::where('buku_id',$id)->where('pengunjung_id',$visitorId)->first();
        if(empty($books->foto)){
            $pict_url = null;
        }else{
        $pict_url = url('image/buku/'.$books->foto);
        }
        $data=[
            "bookId"=> $books->id,
            "judul"=> $books->judul,
            "foto"=> $pict_url,
            "average"=> isset($average[0])?$average[0]->rata:0,
            "penerbit"=> $books->penerbit ,
            'tempat_terbit'=> $books->tempat_terbit,
            "isbn"=> $books->isbn ,
            'rating'=> isset($ratings)?$ratings->nilai:0,
            'ulasan'=> isset($ratings)?$ratings->ulasan:null
        ];
        return response()->json([
            'data'=>$data,
            'message'=>'berhasil fetch data',
            'code'=> 200
        ],200);
    }

    public function searchBook(Request $request)
    {
        $books = Book::where('judul','like','%'.$request->keyword.'%')->paginate(10);
        $books->appends(Input::except('page'));
        $books->getCollection()->transform(function($value){
            if(empty($value->foto)){
                $foto = null;
            }else{
                $foto= url('image/buku/'.$value->foto);
            }
            return [
                'id_buku'=> $value->id,
                'judul'=>$value->judul,
                'penerbit'=> $value->penerbit,
                'isbn'=>$value->isbn,
                'tempat_terbit'=> $value->tempat_terbit,
                'foto'=>$foto
            ];
        });
        return response()->json($books,200);
    }

    public function getRecommend()
    {
        $recommend = Recommend::where('pengunjung_id',Auth::user()->visitor->id)->get();
        if (count($recommend) ==0) {
           $data = null;
        } else {

            foreach ($recommend as $item) {
                if(empty($item->buku->foto)){
                    $foto = null;
                }else{
                    $foto= url('image/buku/'.$item->buku->foto);
                }
                $data[] = [
                    "id_buku"=> $item->buku_id,
                    "judul"=> $item->buku->judul,
                    "penerbit"=> $item->buku->penerbit,
                    "foto"=> $foto,
                ];
            }
        }
        return response()->json([
            'data'=>$data,
            'message'=> 'berhasil',
            'code'=>200,
        ]);
    }

    public function saveRate(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            Rating::updateOrCreate([
                'pengunjung_id'=> Auth::user()->visitor->id,
                'buku_id'=> $data['buku_id']
            ],[
                'nilai'=> $data['nilai'],
                'ulasan'=> $data['ulasan']
            ]);
            DB::commit();
            return response()->json([
                'message'=>'berhasil tambah rating',
                'code'=>200
            ],200);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function allRate($bookId)
    {
        $rate = Rating::where('buku_id',$bookId)->get();
        if(count($rate) == 0){
            $data=null;
        }else{
            foreach ($rate as $item) {
                if(empty($item->visitor->foto_profil)){
                    $foto = null;
                }else{
                    $foto= url('image/pengunjung/'.$item->visitor->foto_profil);
                }
                $data[]=[
                    'visitor_name'=> $item->visitor->nama_pengunjung,
                    'foto'=>$foto,
                    'rating'=> $item->nilai,
                    'ulasan'=>$item->ulasan
                ];
            }
        }
        return response()->json([
            'data'=>$data,
            'message'=> 'berhasil ambil data',
            'code'=> 200
        ],200);
    }
    public function mostRatedBook()
    {

      $average = Rating::join('buku','rating.buku_id','=','buku.id')
                ->selectRaw('buku.judul , buku.foto, buku.id, avg(nilai) as rata')
                ->groupBy('judul','foto','id')
                ->limit(10)
                ->get();
      $data=[];
      foreach ($average as $item) {
        if(empty($item->foto)){
            $foto = null;
        }else{
            $foto= url('image/buku/'.$item->foto);
        }
            $data[]=[
                'id'=> $item->id,
                'judul'=> $item->judul,
                'foto'=> $foto,
                'average'=> $item->rata
            ];

        }
        return response()->json([
            'data'=>$data,
            'message'=> 'berhasil ambil data',
            'code'=> 200
        ],200);

    }
}
