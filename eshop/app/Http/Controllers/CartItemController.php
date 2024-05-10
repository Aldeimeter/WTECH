<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userid = Auth::id();
        $cartitems = DB::table("users")
        ->join("cart_items", "cart_items.userid", "=", "users.id")
        ->join("books", "books.id", "=", "cart_items.bookid")
        ->join("authors_books", "authors_books.book_id", "=", "books.id")
        ->join("authors", "authors_books.author_id", "=", "authors.id")
        ->orderBy("books.name")
        ->select("books.*", "cart_items.amount", "authors.fullname", "cart_items.id as ciid");
        $total = $cartitems->get()->map(function ($el) {
            return $el->price * $el->amount;
        })->sum();
        $cartitems = $cartitems->paginate(2);


        return view("cart", compact("cartitems", "total"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cartitem = new CartItem();
        $cartitem->bookid = $request->input("bookid");
        $cartitem->userid = Auth::id();
        $cartitem->amount = $request->input("amount");
        $cartitem->save();
        return redirect("/cart");
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
    public function update(Request $request, $idslug)
    {
        $amount = $request->input("amount");
        if($amount < 1){
            $cart = CartItem::query()->find($idslug)->update(["amount" => 1]);
            return redirect("/cart");
        }
        $cart = CartItem::query()->find($idslug)->update(["amount" => $amount]);
        return redirect("/cart");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
