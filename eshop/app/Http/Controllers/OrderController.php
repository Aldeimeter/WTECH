<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cartitemstest = DB::table("users")
        ->join("cart_items", "cart_items.userid", "=", "users.id")
        ->where("users.id", "=", Auth::id())
        ->count("cart_items.id");
        if($cartitemstest < 1) {
            return redirect("/cart");
        }
        $order = new Order();
        $order->userid = Auth::id();
        $order->address = $request->input("address");
        $order->payment = $request->input("payment");
        $order->delivery = $request->input("delivery");
        $order->date = now();
        $order->save();
        $cart = DB::table("users")
        ->join("cart_items", "cart_items.userid", "=", "users.id")
        ->where("users.id", "=", Auth::id())
        ->select("cart_items.*");
        $cartitems = $cart->get();
        $cartitems->each(function ($item, $key) use ($order){
            $orderitem = new OrderItems();
            $orderitem->bookid = $item->bookid;
            $orderitem->orderid = $order->id;
            $orderitem->amount = $item->amount;
            $orderitem->save();
            CartItem::query()->find($item->id)->delete();
        });


        return redirect("/");

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
