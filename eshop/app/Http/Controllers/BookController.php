<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Image;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource or search results based on query parameters.
     * @param Request $request
     * @param string|null $genreSlug Optional genre filter, defaults to 'all' for no genre filter.
     * @return View|Factory
     */
    public function index(Request $request): View|Factory
    {
        $query = Book::query()->with('images'); // Using with('images') assumes that there is a relationship named 'images' in Book model

        // Handling the search query if present
        $searchQuery = $request->input('q');
        if (!empty($searchQuery)) {
            $query->whereRaw("search_vector @@ plainto_tsquery('simple', ?)", [$searchQuery]);
        }

        $genreSlug = $request->input('genre', 'all');
        // Handling genre filtering
        if ($genreSlug !== 'all') {
            $genre = Genre::where('slug', $genreSlug)->firstOrFail();
            $query->whereHas('genres', function (Builder $q) use ($genre) {
                $q->where('id', $genre->id);
            });
        } else {
            $genre = new Genre(['name' => 'Všetky žánre']); // Assuming Genre model has a name field
        }

        // Additional filtering based on price, date, and language
        if ($request->filled('price-from')) {
            $query->where('price', '>=', $request->input('price-from'));
        }
        if ($request->filled('price-to')) {
            $query->where('price', '<=', $request->input('price-to'));
        }
        if ($request->filled('date')) {
            $query->where('publish_date', '>=', $request->input('date'));
        }
        if ($request->filled('language') && $request->input('language') !== 'any') {
            $query->where('language', $request->input('language'));
        }

        // Ordering
        if ($request->filled('order') && in_array($request->input('order'), ['asc', 'desc'])) {
            $query->orderBy('price', $request->input('order'));
        } else {
            $query->orderBy('publish_date', 'desc');
        }

        // Pagination of results
        $results = $query->paginate(5);

        // Return the view with all necessary data
        return view('books', compact('results', 'genre', 'searchQuery'));
    }
    /**
     * @return View|Factory
     * @param mixed $idslug
     */
    public function book(Request $request, $idslug): View|Factory{
        $book = Book::with(['authors', 'genres'])
                ->where('id', $idslug)
                ->firstOrFail();

        $amount = $request->input('amount', 1);
        $amount = max(1, (int) $amount); // Ensure amount is at least 1

        $images = DB::table("images")
        ->leftJoin("books", "images.book_id", "=", "books.id")
        ->select("images.id", "images.alt_text")
        ->where("books.id", "=", $idslug)
        ->get();

        return view("book", compact("book", "amount", "images"));

    }
    /**
     * @return View|Factory
     */
    public function admin(Request $request): View|Factory
    {
        $genres = DB::table("genres")->select("slug", "name")->get();
        $fail = "";
        if($request->has("fail")){
            $fail = "Také meno už existuje.";
        }
        return view("admin", compact("genres", "fail"));
    }
    /**
     * @return Redirector|RedirectResponse
     */
    public function create(Request $request): Redirector|RedirectResponse
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
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     * @return View|Factory
     * @param mixed $id
     */
    public function show(Request $request, $id): View|Factory
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
     * @return void
     */
    public function edit(string $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @return Redirector|RedirectResponse
     */
    public function update(Request $request, string $id): Redirector|RedirectResponse
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
     * @return Redirector|RedirectResponse
     */
    public function destroy(string $id): Redirector|RedirectResponse
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
    /**
     * @return Redirector|RedirectResponse
     */
    public function destroyImages(string $id): Redirector|RedirectResponse
    {
        DB::table("images")
        ->where("book_id", "=", $id)->delete();
        return redirect("/books/" . $id);
    }
    /**
     * @return string
     * @param mixed $text
     */
    private function slugify($text): string { //https://lucidar.me/en/web-dev/how-to-slugify-a-string-in-php/
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
