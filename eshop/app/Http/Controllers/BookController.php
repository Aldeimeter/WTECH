<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Genre;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $genreSlug)
    {
        $genre = new Genre;
        $query = Book::query();
        if($genreSlug!='all'){
            $genre = Genre::firstWhere('slug', $genreSlug);
            $query = $genre->books();
        }
        if($request->has('price-from') && $request->input('price-from') != ''){
            $query->where('price', '>=', $request->input('price-from'));
        }
        if($request->has('price-to') && $request->input('price-to') != ''){
            $query->where('price', '<=', $request->input('price-to'));
        }
        if($request->has('date') && $request->input('date') != ''){
            $query->where('date', '>=', $request->input('date'));
        }
        if($request->has('language') && $request->input('language') != 'any'){
            $query->where('language', '=', $request->input('language'));
        }
        if($request->has('order') && ($request->input('order')=='asc' || $request->input('order')=='desc')){
            $query->orderBy('price',$request->input('order'));
        }
        $genre->name = 'All';
        $results = $query->paginate(2);
        return view('books', compact('results','genre'));
    }
    public function search(Request $request)
    {
        echo $request->search;
        $books = Book::whereRaw("search_vector @@ plainto_tsquery('simple', ?)", [$request->search])->get();
        echo $books;
    }

    public function book(Request $request, $idslug){
        $query = Book::query()->where("id", "=", $idslug);
        $results = $query->get();
        return view("book", compact("results"));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
