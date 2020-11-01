<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use App\Visitor;
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
}
