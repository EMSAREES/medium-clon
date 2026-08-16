<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * El usuario autenticado empieza a seguir a $user.
     */
    public function store(User $user): RedirectResponse
    {
        // Un usuario no puede seguirse a sí mismo.
        abort_if($user->id === Auth::id(), 403, 'No puedes seguirte a ti mismo.');

        // syncWithoutDetaching agrega la relación en la tabla pivote
        // "followers" sin quitar los seguidos anteriores (a diferencia
        // de sync(), que reemplazaría TODA la lista). Si ya lo seguía,
        // no hace nada raro: simplemente no duplica la fila (gracias
        // también a la restricción unique() que pusimos en la migración).
        Auth::user()->following()->syncWithoutDetaching($user->id);

        return back()->with('success', "Ahora sigues a {$user->name}.");
    }

    /**
     * El usuario autenticado deja de seguir a $user.
     */
    public function destroy(User $user): RedirectResponse
    {
        Auth::user()->following()->detach($user->id);

        return back()->with('success', "Dejaste de seguir a {$user->name}.");
    }
}
