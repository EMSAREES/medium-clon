<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'published_at',
    ];

    // Le dice a Eloquent que convierta automáticamente published_at
    // en un objeto Carbon (fecha) en vez de un string plano.
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
