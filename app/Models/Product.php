<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'summary',
        'start_date',
        'end_date',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class, 'id', 'category_id');
    }
}
