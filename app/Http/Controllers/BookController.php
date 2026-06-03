<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreBookRequest;
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

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'published_date' => $validated['published_date'],
            'description' => $validated['description'],
            'image_url' => $validated['image_url'],
            'user_id' => auth()->id(),
        ]);

        $book->genres()->sync($validated['genres']);

        return redirect()
            ->route('books.index')
            ->with('success', '書籍を登録しました');
    }
}
