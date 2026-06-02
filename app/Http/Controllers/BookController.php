<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Book;
use App\Models\Genre;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::with('genres')
            ->orderBy('id')
            ->paginate(10);
        
        return view('books.index', compact('books'));
    }

    public function show(Book $book): View
    {
        $book->load('genres', 'reviews');

        return view('books.show', compact('book'));
    }

    public function create(): View
    {
        $genres = Genre::all();

        return view('books.create', compact('genres'));
    }

}
