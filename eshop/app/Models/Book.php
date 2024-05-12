<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
      protected static function booted()
        {
            static::saved(function ($book) {
                // Update the search_vector manually
                $book->updateSearchVector();
            });
        }

        public function updateSearchVector()
        {
            DB::table('books')
                ->where('id', $this->id)
                ->update([
                    'search_vector' => DB::raw("setweight(to_tsvector('simple', name), 'A') || setweight(to_tsvector('simple', coalesce(description,'')), 'B')")
                ]);
        }
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'language',
        'publish_date',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'publish_date' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genres_books');
    }


    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'authors_books');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function scopeOfLanguage($query, $language)
    {
        return $query->where('language',$language);
    }

}
