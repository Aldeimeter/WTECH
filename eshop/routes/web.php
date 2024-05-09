<?php

use Illuminate\Support\Facades\Route;
use App\Models\Genre;
Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/books/genre/{Genre}', [App\Http\Controllers\BookController::class, 'index'])->name('books.genre');
Route::get('/search', [App\Http\Controllers\BookController::class, 'search'])->name('books.search');
Route::get('/books/{id}', [App\Http\Controllers\BookController::class, 'book'])->name('books.book');
