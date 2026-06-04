<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Book;

class RankingController extends Controller
{
    public function index(): View
    {
        $rankedBooks = Book::whereHas('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(10)
            ->get();
        
        return view('ranking.index', compact('rankedBooks'));
    }
}
