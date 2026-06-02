<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// 書籍画面
// ログイン不要
Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// ログイン必須
Route::middleware('auth')->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');

    Route::post('/', fn() => '準備中')->name('books.store');
    Route::get('/ranking', fn() => '準備中')->name('ranking.index');
    Route::get('/favorites', fn() => '準備中')->name('favorites.index');
    Route::get('/genres', fn() => '準備中')->name('genres.index');
});