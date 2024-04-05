<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    /*
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'genres_books');
    }
}
