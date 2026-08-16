<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * El autor del post.
     * Uso: $post->author->name
     *
     * Nota: aunque la columna se llama "user_id", llamamos al método
     * author() (no user()) porque es más expresivo en este contexto.
     * Como el nombre no calza con la convención automática, le
     * indicamos explícitamente la foreign key.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * La categoría a la que pertenece el post.
     * Uso: $post->category->name
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Las filas de "claps" (aplausos) que ha recibido este post.
     * Uso: $post->claps->sum('count')  -> total de aplausos
     */
    public function claps(): HasMany
    {
        return $this->hasMany(Clap::class);
    }

    /**
     * Le dice a Laravel que use "slug" en vez de "id" al resolver
     * el modelo automáticamente en las rutas (Route Model Binding).
     * Uso: Route::get('/posts/{post}', ...) ahora busca por slug.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
 * Total de aplausos que ha recibido este post (sumando el
 * "count" de todas las filas de la tabla claps), sin importar
 * cuántos usuarios distintos aplaudieron.
 */
public function totalClaps(): int
{
    return $this->claps()->sum('count');
}

    /**
     * Cuántos claps dio un usuario específico en este post.
     * Devuelve 0 si el usuario es null (invitado) o si nunca aplaudió.
     */
    public function clapsFromUser(?User $user): int
    {
        if (! $user) {
            return 0;
        }

        return $this->claps()->where('user_id', $user->id)->value('count') ?? 0;
    }
}
