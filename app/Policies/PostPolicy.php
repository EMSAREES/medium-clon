<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

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
}
