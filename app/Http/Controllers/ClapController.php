<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ClapController extends Controller
{
    /**
     * Registra (o incrementa) un "clap" del usuario autenticado
     * sobre un post. Como en Medium, un mismo usuario puede
     * aplaudir varias veces el mismo post — no una sola vez — pero
     * hasta un máximo de 50, para evitar abuso.
     */
    public function store(Post $post): RedirectResponse
    {
        // firstOrCreate busca una fila con post_id + user_id.
        // Si ya existe (el usuario ya había aplaudido antes), la
        // reutiliza; si no existe, crea una nueva con count = 0.
        // Como $post->claps() ya es una relación hasMany filtrada
        // por post_id, no hace falta repetirlo en el array.
        $clap = $post->claps()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['count' => 0]
        );

        if ($clap->count < 50) {
            $clap->increment('count');
        }

        // Vuelve a la página anterior (normalmente posts.show),
        // conservando los query params si los hubiera.
        return back();
    }
}
