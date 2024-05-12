<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $fillable = ["bookid", "userid", "amount"];

    public function books(): HasOne {
        return $this->hasOne(Book::class, "books");
    }

    public function users(): HasOne {
        return $this->hasOne(User::class, "users");
    }

}
