<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    public $incrementing = false;

    protected $fillable = ['category_id', 'title', 'contents'];

    protected $casts = [
        'id' => 'string',
        'category_id' => 'string'
    ];

    public $timestamps = true;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
