<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $fillable = ["userid", "address", "payment", "delivery", "date"];

    public function users(): HasOne {
        return $this->hasOne(User::class, "users");
    }

    public function orderitems(): HasMany {
        return $this->hasMany(OrderItems::class, "order_items");
    }
}
