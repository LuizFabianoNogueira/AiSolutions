<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
