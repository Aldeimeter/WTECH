<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});
Auth::routes();
Route::resource('/cart', App\Http\Controllers\CartItemController::class);
Route::resource('/order', App\Http\Controllers\OrderController::class);

Route::get('/books/{id}', [App\Http\Controllers\BookController::class, 'book'])->name('books.book');
Route::get('/search', [App\Http\Controllers\BookController::class, 'index'])->name('books.search');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['isAdmin' ])->prefix('admin')->group(function () {
    Route::get('/books', [App\Http\Controllers\BookController::class, 'admin'])->name('books.admin');
    Route::put('/books/delete/{id}', [App\Http\Controllers\BookController::class, 'destroy'])->name('books.destroy');
    Route::put('/books/deleteimages/{id}', [App\Http\Controllers\BookController::class, 'destroyImages'])->name('books.destroyImages');
    Route::post('/books/create', [App\Http\Controllers\BookController::class, 'create'])->name('books.create');
    Route::put('/books/update/{id}', [App\Http\Controllers\BookController::class, 'update'])->name('books.update');
    Route::get('/books/show/{id}', [App\Http\Controllers\BookController::class, 'show'])->name('books.show');
});
