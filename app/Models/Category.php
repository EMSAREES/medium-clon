<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // Campos que se pueden asignar con Category::create([...])
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Todos los posts que pertenecen a esta categoría.
     * Uso: $category->posts
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
