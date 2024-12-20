<?php

namespace App\Models;

use App\Enums\Status;
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
        'status',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }
}
