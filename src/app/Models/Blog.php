<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'published_at',
        'description',
        'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

}
