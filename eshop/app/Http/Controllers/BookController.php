<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Image;
use Exception;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $genreSlug)
    {
        $genre = new Genre;
        $query = DB::table('books')
        ->leftJoin("images", "books.id", "=", "images.book_id")
        ->select("books.*", "images.id as imageid", "images.alt_text");
        if($genreSlug!='all'){
            $genre = Genre::firstWhere('slug', $genreSlug);
            $query = $genre->books();
        }
        if($request->has('price-from') && $request->input('price-from') != ''){
            $query->where('books.price', '>=', $request->input('price-from'));
        }
        if($request->has('price-to') && $request->input('price-to') != ''){
            $query->where('books.price', '<=', $request->input('price-to'));
        }
        if($request->has('date') && $request->input('date') != ''){
            $query->where('books.date', '>=', $request->input('date'));
        }
        if($request->has('language') && $request->input('language') != 'any'){
            $query->where('books.language', '=', $request->input('language'));
        }
        $query->orderBy("books.publish_date", "desc", "books.name", "desc");
        if($request->has('order') && ($request->input('order')=='asc' || $request->input('order')=='desc')){
            $query->orderBy('books.price',$request->input('order'));
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
        $query = DB::table("books")
        ->join("authors_books", "authors_books.book_id", "=", "books.id")
        ->join("authors", "authors_books.author_id", "=", "authors.id")
        ->join("genres_books", "books.id", "=", "genres_books.book_id")
        ->join("genres", "genres.id", "=", "genres_books.genre_id")
        ->select("books.*", "authors.fullname", "genres.name as genre_name")
        ->where("books.id", "=", $idslug);
        $results = $query->get();
        $amount = $request->input("amount");
        if(is_null($amount) || $amount < 1){
            $amount = 1;
        }
        $images = DB::table("images")
        ->leftJoin("books", "images.book_id", "=", "books.id")
        ->select("images.id", "images.alt_text")
        ->where("books.id", "=", $idslug)
        ->get();
        return view("book", compact("results", "amount", "images"));

    }

    public function admin(Request $request)
    {
        $genres = DB::table("genres")->select("slug", "name")->get();
        $fail = "";
        if($request->has("fail")){
            $fail = "Také meno už existuje.";
        }
        return view("admin", compact("genres", "fail"));
    }

    public function create(Request $request)
    {
        $book = new Book();
        $book->name = $request->input("book-name");
        if(DB::table("books")->where("name", "=", $book->name)->count() > 0){
            return redirect("books/admin?fail=t");
        }
        $book->slug = $this->slugify($book->name);
        $book->price = (float)$request->input("price");
        $book->language = $request->input("language");
        $book->publish_date = $request->input("date");
        $book->description = $request->input("description");
        $book->save();
        if(DB::table("authors")
        ->where("fullname", "=", $request->input("author"))
        ->count("id") === 0){
            $author = new Author();
            $author->fullname = $request->input("author");
            $author->save();
        }
        $authorid = DB::table("authors")
        ->where("fullname", "=", $request->input("author"))
        ->select("id")
        ->first();
        $book->authors()->attach($authorid);
        foreach($request->input("genres") as $g){
            $gid = DB::table("genres")
            ->where("slug", "=", $g)
            ->select("id")
            ->first();
            $book->genres()->attach($gid);
        }
        $images = $request->file('images');
        $imagepaths = array();
        if($request->hasFile("images")){
            foreach($images as $img){
                $prefix = date_format(now(), "YmdHis");
                $imagename = $prefix . $img->getClientOriginalName();
                $img->move(base_path(). "/public/img/", $imagename);
                $imagepaths[] = $imagename;
            }
        }
        foreach($imagepaths as $imgname){
            if(!is_null(Image::query()->find($imgname))){
                continue;
            }
            $img = new Image();
            $img->id = $imgname;
            $img->book_id = $book->id;
            $img->alt_text = $book->name;
            $img->save();
        }
        return redirect("/books/" . $book->id);
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
    public function show(Request $request, $id)
    {
        $book = DB::table("books")->select("*")->where('id', "=", $id)->first();
        $author = DB::table("authors")
        ->join("authors_books", "authors_books.author_id", "=", "authors.id")
        ->join("books", "authors_books.book_id", "=", "books.id")
        ->where("books.id", "=", $id)
        ->select("authors.fullname")
        ->first();
        $genresIncluded = DB::table("genres")
        ->join("genres_books", "genres_books.genre_id", "=", "genres.id")
        ->join("books", "genres_books.book_id", "=", "books.id")
        ->where("books.id", "=", $id)
        ->select("genres.*")
        ->get();
        $includedIds = $genresIncluded->map(function($element){
            return $element->id;
        });
        $genresExcluded = DB::table("genres")
        ->select("genres.*")
        ->get();
        $genresExcluded = $genresExcluded->filter(function($value) use ($includedIds){
            return !in_array($value->id, $includedIds->toArray());
        });
        return view("adminshow", compact("book", "genresIncluded", "genresExcluded", "author"));
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
        $book = Book::query()->find($id);
        $book->name = $request->input("book-name");
        $book->slug = $this->slugify($book->name);
        $book->price = (float)$request->input("price");
        $book->language = $request->input("language");
        $book->publish_date = $request->input("date");
        $book->description = $request->input("description");
        $book->save();
        if(DB::table("authors")
        ->where("fullname", "=", $request->input("author"))
        ->count("id") === 0){
            $author = new Author();
            $author->fullname = $request->input("author");
            $author->save();
        }
        $authorid = DB::table("authors")
        ->where("fullname", "=", $request->input("author"))
        ->select("id")
        ->first();
        try{
            $book->authors()->attach($authorid);
        }
        catch(Exception $error){}
        foreach($request->input("genres") as $g){
            $gid = DB::table("genres")
            ->where("slug", "=", $g)
            ->select("id")
            ->first();
            try{
                $book->genres()->attach($gid);
            }
            catch(Exception $error){}
        }
        $images = $request->file('images');
        $imagepaths = array();
        if($request->hasFile("images")){
            foreach($images as $img){
                $prefix = date_format(now(), "YmdHis");
                $imagename = $prefix . $img->getClientOriginalName();
                $img->move(base_path(). "/public/img/", $imagename);
                $imagepaths[] = $imagename;
            }
        }
        foreach($imagepaths as $imgname){
            if(!is_null(Image::query()->find($imgname))){
                continue;
            }
            $img = new Image();
            $img->id = $imgname;
            $img->book_id = $book->id;
            $img->alt_text = $book->name;
            $img->save();
        }
        return redirect("/books/" . $book->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table("cart_items")
        ->where("bookid", "=", $id)->delete();
        DB::table("order_items")
        ->where("bookid", "=", $id)->delete();
        DB::table("genres_books")
        ->where("book_id", "=", $id)->delete();
        DB::table("authors_books")
        ->where("book_id", "=", $id)->delete();
        DB::table("images")
        ->where("book_id", "=", $id)->delete();
        Book::query()->find($id)->delete();
        return redirect("/");
    }

    public function destroyImages(string $id)
    {
        DB::table("images")
        ->where("book_id", "=", $id)->delete();
        return redirect("/books/" . $id);
    }

    private function slugify($text) { //https://lucidar.me/en/web-dev/how-to-slugify-a-string-in-php/
        // Strip html tags
        $text=strip_tags($text);
        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // Transliterate
        setlocale(LC_ALL, 'en_US.utf8');
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // Trim
        $text = trim($text, '-');
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // Lowercase
        $text = strtolower($text);
        // Check if it is empty
        if (empty($text)) { return 'n-a'; }
        // Return result
        return $text;
    }
}
