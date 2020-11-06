<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use App\Visitor;
use App\Similarity;
use App\Recommend;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function showCalc()
    {
        $books = Book::all();
        $visitors = Visitor::all();
        $rating = Rating::all();
        $data = $this->createMatrix();
        return view('perhitungan.show',compact(
            'books',
            'visitors',
            'data'
        ));
    }

    public function createMatrix()
    {
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

    public function cosineSimilarity(Request $request)
    {
        $data = $this->createMatrix();
        $itemKosong =[];
        $books = Book::all();
        $similarity = 0;
        $sumRate = 0;
        $sumItemA=0;
        $sumItemB=0;
        $result=0;
        $countVisitor = Visitor::count();
        $id = $request->id;
        $dataApi =[];

        // buku yg udah dirating user
        $userRatingBook = Rating::where('pengunjung_id',$id)->get();

        // buku yg udah dirating user lainnya
        $userRating = Rating::select('pengunjung_id')->where('pengunjung_id', '<>', $id)->distinct()->get();

        // set data buku kosong belom di rating si user
        foreach ($books as  $book) {
            if (!isset($data[$id][$book->id])) {
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

                        $pengunjungnya[$visitorId2] = [$data[$visitorId2][$bukuId1],$data[$visitorId2][$bukuId2]];

                    }


                }



                if ($sumItemB !=0 && $sumItemA !=0) {
                    $similarity = $sumRate/(sqrt($sumItemA)*sqrt($sumItemB));
                    $roundSim = round($similarity,3);
                    if ($similarity < 1) {
                        Similarity::UpdateOrCreate(
                            ['buku_id1'=> $bukuId1,
                            'buku_id2'=>$bukuId2,
                            'pengunjung_id'=> $id
                        ],[
                                'nilai_cosine'=> $roundSim
                            ]
                            );
                            $sumRate = 0;
                            $sumItemA = 0;
                            $sumItemB = 0;
                    }
                    }
                    $dataApi[] =[
                        "bookid1"=> $bukuId1,
                        "bookid2"=>$bukuId2,
                        "other_visitor"=>$pengunjungnya,
                        "similarity"=>round($similarity,2)
                    ];
                    $pengunjungnya = [];
            }

        }

        return response()->json([$dataApi,"visitorcount"=>$countVisitor],200);
        // $this->prediction($data, $itemKosong, $id);
    }

    public function prediction(Request $request)
    {
       $data = $this->createMatrix();
       // $itemKosong=[];
       $books = Book::all();
       $sim = [];
       $sumAtas=0;
       $id = $request->id;
       $sumBawah=0;


    //  rating yg kosong
    foreach ($books as  $book) {
        if (!isset($data[$id][$book->id])) {
            $itemKosong[] =$book->id;
        }
    }

       //cari nilai rekomendasi untuk rating yg kosong
       for ($i=0; $i <count($itemKosong); $i++) {
           $idItem1 = $itemKosong[$i];

           $similarity= Similarity::where('buku_id1',$idItem1)->where('pengunjung_id',$id)->get();
           foreach ($similarity as $item) {
               $idBuku1 = $item->buku_id1;
               $idBuku2 = $item->buku_id2;
               $sim[$idBuku1][$idBuku2] = $item->nilai_cosine;

               if (isset($data[$id][$idBuku2])) {
                   $perkalian = $sim[$idBuku1][$idBuku2] * $data[$id][$idBuku2];
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
                       'pengunjung_id'=>$id
                   ],
                   [
                        'nilai_prediksi'=>$roundPrediksi
                   ]
                   );
                   $dataApi[]= [
                    "buku_id"=>$idItem1,
                    "nilai_prediksi"=>$roundPrediksi
                   ];
                   $sumAtas = 0;
                   $sumBawah=0;
               }
       }
       return response()->json($dataApi,200);
    }
}
