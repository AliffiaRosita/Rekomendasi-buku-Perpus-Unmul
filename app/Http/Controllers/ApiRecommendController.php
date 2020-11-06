<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use App\Similarity;
use App\Visitor;
use App\Recommend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ApiRecommendController extends Controller
{

    public function createMatrix()
    {
        set_time_limit(0);
        $userRating = Rating::select('pengunjung_id')->distinct()->get();
        $ratings = Rating::all();
        $dataPengunjungId=[];
        $data=[];

        for ($i=0; $i < count($userRating); $i++) {
            $dataPengunjungId[]= $userRating[$i]->pengunjung_id;
            foreach ($ratings as $rating) {
                if($rating->pengunjung_id == $dataPengunjungId[$i]){
                    $pengunjungId = $dataPengunjungId[$i];
                    $data[$pengunjungId][$rating->buku_id]= $rating->nilai;
                }
            }
        }
        return $data;
    }

    // cara bu vina
    public function hitungSimilarity()
    {
        $data = $this->createMatrix();
        $countBook = Book::count();
        $similarity = 0;
        $sumRate = 0;
        $sumItemA=0;
        $sumItemB=0;
        $result=0;
        $visitors = Visitor::all();
        for ($i=1; $i <= $countBook ; $i++) {
            for ($j=$i+1; $j <= $countBook; $j++) {
                    foreach ($visitors as $visitor) {
                        $visitorId =$visitor->id;
                        if(isset($data[$visitorId][$i]) && isset($data[$visitorId][$j])){
                            $result= $data[$visitorId][$i] * $data[$visitorId][$j];
                            $kuadratItemA = $data[$visitorId][$i] * $data[$visitorId][$i];
                            $kuadratItemB = $data[$visitorId][$j] * $data[$visitorId][$j];
                                $sumRate = $sumRate + $result;
                                $sumItemA = $sumItemA +$kuadratItemA;
                                $sumItemB = $sumItemB +$kuadratItemB;
                    }
                }
                if ($sumItemB !=0 && $sumItemA !=0) {
                    $similarity = $sumRate/(sqrt($sumItemA)*sqrt($sumItemB));
                }else{
                    $similarity = 0;
                }

                Similarity::UpdateOrCreate(
                    ['buku_id1'=> $i,
                    'buku_id2'=>$j],[
                        'nilai_cosine'=> $similarity
                    ]
                    );
         }
    }


     }

    //  cara ita
    public function cosineSimilarity($visitorId)
    {
        $data = $this->createMatrix();
        $itemKosong =[];
        $books = Book::all();
        $similarity = 0;
        $sumRate = 0;
        $sumItemA=0;
        $sumItemB=0;
        $result=0;

        // buku yg udah dirating user
        $userRatingBook = Rating::where('pengunjung_id',$visitorId)->get();

        // buku yg udah dirating user lainnya
        $userRating = Rating::select('pengunjung_id')->where('pengunjung_id', '<>', $visitorId)->distinct()->get();

        // set data buku kosong belom di rating si user
        foreach ($books as  $book) {
            if (!isset($data[$visitorId][$book->id])) {
                $itemKosong[] =$book->id;
            }
        }

        for ($i=0; $i <count($itemKosong) ; $i++) {
            $bukuId1= $itemKosong[$i];
            $bukubisadipasangkan = [];
            foreach ($userRatingBook as  $userRat) {
                $bukuId2 = $userRat->buku_id;
                $nilaiBisa =0;
                foreach ($userRating as $otherRat) {
                    $visitorId2 =$otherRat->pengunjung_id;
                    if(isset($data[$visitorId2][$bukuId1])&& isset($data[$visitorId2][$bukuId2])){
                        $nilaiBisa++;
                    }
                }
                if ($nilaiBisa >=2) {
                    $bukubisadipasangkan[] = $userRat->buku_id;
                }
            }

            for ($j=0; $j < count($bukubisadipasangkan); $j++) {
                $bukuId2 = $bukubisadipasangkan[$j];
                foreach ($userRating as $userRat) {
                    $visitorId2 = $userRat->pengunjung_id;
                    if(isset($data[$visitorId2][$bukuId1])&& isset($data[$visitorId2][$bukuId2])){
                        $result= $data[$visitorId2][$bukuId1] * $data[$visitorId2][$bukuId2];
                        $kuadratItemA = $data[$visitorId2][$bukuId1] * $data[$visitorId2][$bukuId1];
                        $kuadratItemB = $data[$visitorId2][$bukuId2] * $data[$visitorId2][$bukuId2];
                        $sumRate = $sumRate + $result;
                        $sumItemA = $sumItemA +$kuadratItemA;
                        $sumItemB = $sumItemB +$kuadratItemB;
                    }
                }

                if ($sumItemB !=0 && $sumItemA !=0) {
                    $similarity = $sumRate/(sqrt($sumItemA)*sqrt($sumItemB));
                    $roundSim = round($similarity,3);
                    if ($similarity < 1) {
                        Similarity::UpdateOrCreate(
                            ['buku_id1'=> $bukuId1,
                            'buku_id2'=>$bukuId2,
                            'pengunjung_id'=> $visitorId
                        ],[
                                'nilai_cosine'=> $roundSim
                            ]
                            );
                            $sumRate = 0;
                            $sumItemA = 0;
                            $sumItemB = 0;
                    }
                    }
            }
        }
        $this->prediction($data, $itemKosong, $visitorId);
    }

     public function prediction($data,$itemKosong,$visitorId)
     {
        //$data = $this->createMatrix();
       // $itemKosong=[];
        // $books = Book::all();
        $sim = [];
        $sumAtas=0;
        //$visitorId = 1; //nanti ganti pakai auth id
        $sumBawah=0;

        //cari nilai rekomendasi untuk rating yg kosong
        for ($i=0; $i <count($itemKosong); $i++) {
            $idItem1 = $itemKosong[$i];

            $similarity= Similarity::where('buku_id1',$idItem1)->where('pengunjung_id',$visitorId)->get();
            foreach ($similarity as $item) {
                $idBuku1 = $item->buku_id1;
                $idBuku2 = $item->buku_id2;
                $sim[$idBuku1][$idBuku2] = $item->nilai_cosine;

                if (isset($data[$visitorId][$idBuku2])) {
                    $perkalian = $sim[$idBuku1][$idBuku2] * $data[$visitorId][$idBuku2];
                    $sumAtas = $sumAtas+$perkalian;
                    $sumBawah = $sumBawah + $sim[$idBuku1][$idBuku2];
                }

            }
            if ($sumAtas!=0 && $sumBawah !=0) {
                $prediksi = $sumAtas/$sumBawah;
                $roundPrediksi = round($prediksi,3);
                Recommend::updateOrCreate(
                    [
                        'buku_id'=> $idItem1,
                        'pengunjung_id'=>$visitorId
                    ],
                    [
                         'nilai_prediksi'=>$roundPrediksi
                    ]
                    );
                    $sumAtas = 0;
                    $sumBawah=0;
                }
        }
     }

     public function getRecommend()
     {
         $visitorId = Auth::user()->visitor->id;
         $this->cosineSimilarity($visitorId);

         $recommend = Recommend::where('pengunjung_id',$visitorId)
                        ->orderBy('nilai_prediksi','DESC')
                        ->limit(5)
                        ->get();
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
                     "nilai_prediksi"=> $item->nilai_prediksi,
                     "judul"=> $item->buku->judul,
                     "penerbit"=> $item->buku->penerbit,
                     "deskripsi"=> $item->buku->deskripsi,
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

}
