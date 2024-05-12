<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Image extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alt_text',
        'id',
        'book_id',
    ];

    protected $primaryKey = 'id';
    protected $keyType = "string";
    public $incrementing = false;

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
