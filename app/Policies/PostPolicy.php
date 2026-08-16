<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;


/**
 * PostPolicy
 * ----------
 * Una Policy centraliza las reglas de "quién puede hacer qué"
 * sobre un modelo específico — en este caso, Post.
 *
 * En vez de esparcir validaciones como
 * "if ($post->user_id !== auth()->id()) abort(403);"
 * en cada método del controlador (y repetirlas de nuevo en las
 * vistas Blade), las definimos UNA sola vez aquí y las reutilizamos
 * en todos lados:
 *
 *   - En el controlador: $this->authorize('update', $post);
 *   - En Blade:           @can('update', $post) ... @endcan
 *   - En tests:           $user->can('update', $post)
 *
 * Laravel la detecta y la conecta automáticamente con el modelo
 * Post gracias a la convención de nombres (Post -> PostPolicy),
 * sin necesidad de registrarla a mano en ningún ServiceProvider.
 */
class PostPolicy
{
    /**
     * ¿Puede $user editar este $post?
     * Devuelve true solo si el usuario logueado es el autor.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * ¿Puede $user borrar este $post?
     * Usamos la misma regla que update: solo el autor.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * ¿Puede $user ver este $post?
     * - Si está publicado, cualquiera puede verlo (incluso invitados).
     * - Si es un borrador, solo el autor puede verlo.
     */
    public function view(?User $user, Post $post): bool
    {
        if ($post->published_at !== null) {
            return true;
        }

        return $user?->id === $post->user_id;
    }
}
