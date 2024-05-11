<?php

use Illuminate\Support\Facades\Route;
use App\Models\Genre;
Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/books/genre/{Genre}', [App\Http\Controllers\BookController::class, 'index'])->name('books.genre');
Route::get('/books/show/{id}', [App\Http\Controllers\BookController::class, 'show'])->name('books.show');
Route::post('/books/create', [App\Http\Controllers\BookController::class, 'create'])->name('books.create');
Route::put('/books/update/{id}', [App\Http\Controllers\BookController::class, 'update'])->name('books.update');
Route::put('/books/delete/{id}', [App\Http\Controllers\BookController::class, 'destroy'])->name('books.destroy');
Route::put('/books/deleteimages/{id}', [App\Http\Controllers\BookController::class, 'destroyImages'])->name('books.destroyImages');
Route::get('/books/admin', [App\Http\Controllers\BookController::class, 'admin'])->name('books.admin');
Route::get('/search', [App\Http\Controllers\BookController::class, 'search'])->name('books.search');
Route::resource('/cart', App\Http\Controllers\CartItemController::class);
Route::resource('/order', App\Http\Controllers\OrderController::class);
Route::get('/books/{id}', [App\Http\Controllers\BookController::class, 'book'])->name('books.book');
