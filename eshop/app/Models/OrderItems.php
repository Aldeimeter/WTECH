<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItems extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $fillable = ["bookid", "orderid", "amount"];

    public function books(): HasOne {
        return $this->hasOne(Book::class, "books");
    }

    public function orders(): HasOne {
        return $this->hasOne(Order::class, "orders");
    }
}
