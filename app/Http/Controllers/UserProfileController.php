<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Muestra el perfil público de un usuario: sus posts publicados
     * y sus contadores de seguidores/seguidos.
     */
    public function show(User $user): View
    {
        // Cargamos solo los posts PUBLICADOS de este usuario (no
        // queremos exponer borradores de otras personas), junto
        // con su categoría, para evitar el problema N+1 en la vista.
        $user->load([
            'posts' => fn ($query) => $query
                ->whereNotNull('published_at')
                ->with('category')
                ->latest('published_at'),
        ]);

        return view('users.show', compact('user'));
    }
}
