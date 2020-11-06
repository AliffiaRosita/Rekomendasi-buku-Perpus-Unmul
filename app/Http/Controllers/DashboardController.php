<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function monthlyVisitor()
    {
        $book  = Book::count();
        $visitor = Visitor::count();
        $rating = Rating::count();
        return view('landingpage',compact('book','visitor','rating'));

    }

    public function bukuLaris()
    {
        $book = Rating::join('buku','rating.buku_id','=','buku.id')
        ->selectRaw('buku.judul, avg(nilai) as rata')
        ->groupBy('judul')
        ->orderBy('rata','DESC')
        ->limit(5)
        ->get();
        foreach ($book as $item) {
            $data[]= [
                'judul'=> $item->judul,
                'avg'=> round($item->rata,2)
            ];
        }
        return response()->json(['data'=>$data],200);
    }

    public function pengunjungBulanan()
    {

        $visitors = Visitor::select('created_at')->distinct()->get();
        $visitorTraffic = Visitor::select('created_at')
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');// grouping by years
            //return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        // dd($visitorTraffic);

            foreach ($visitors as $visitor) {
                $date = Carbon::parse($visitor->created_at)->format('Y-m-d');
                if (isset($visitorTraffic[$date])) {

                        $data[]=[
                            'date'=>$date,
                            'value'=> count($visitorTraffic[$date]),
                        ];

                }
        }
        return response()->json([
            "data"=>$data
        ],200);
    }
}
