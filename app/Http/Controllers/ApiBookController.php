<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use App\Recommend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class ApiBookController extends Controller
{
    public function getBook()
    {
        $books = Book::paginate(10);
        return response()->json([
            'data'=>$books,
            'message'=>'berhasil fetch data',
            'code'=> 200
        ],200);
    }

    public function detailBook($id)
    {

        $visitorId = 13221; //nanti diganti pake visitor yg ada di login
        $books = Book::findOrFail($id);
        $ratings = Rating::where('buku_id',$id)->where('pengunjung_id',$visitorId)->first();
        $data=[
            "bookId"=> $books->id,
            "judul"=> $books->judul,
            "deskripsi"=> $books->deskripsi,
            "foto"=> $books->foto,
            "penerbit"=> $books->penerbit ,
            "isbn"=> $books->isbn ,
            'rating'=> $ratings->nilai,
            'ulasan'=> $ratings->ulasan
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
        return response()->json([
            'data'=>$books->appends(Input::except('page')),
            'message'=> 'pencarian berhasil',
            'code'=>200,
        ],200);
    }

    public function getRecommend(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $recommend = Recommend::where('pengunjung_id',$user->visitor->id)->get();
        if (count($recommend) == 0) {
           $data = null;
        } else {
            foreach ($recommend as $item) {
                $data[] = [
                    "id_buku"=> $item->buku_id,
                    "judul"=> $item->buku->judul,
                    "deskripsi"=> $item->buku->deskripsi,
                    "foto"=> $item->buku->foto,
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
            $user = User::findOrFail($data['user_id']);
            Rating::updateOrCreate([
                'pengunjung_id'=> $user->visitor->id,
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

    public function AllRate($bookId)
    {
        $rate = Rating::where('buku_id',$bookId)->get();
        foreach ($rate as $item) {
            $data[]=[
                'visitor_name'=> $item->visitor->nama_pengunjung,
                'rating'=> $item->nilai,
                'ulasan'=>$item->ulasan
            ];
        }
        return response()->json([
            'data'=>$data,
            'message'=> 'berhasil ambil data',
            'code'=> 200
        ],200);
    }
}
