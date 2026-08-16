<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(User $user): RedirectResponse
    {
        abort_if($user->id === Auth::id(), 403, 'No puedes seguirte a ti mismo.');

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        $currentUser->following()->syncWithoutDetaching($user->id);

        return back()->with('success', "Ahora sigues a {$user->name}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        $currentUser->following()->detach($user->id);

        return back()->with('success', "Dejaste de seguir a {$user->name}.");
    }
}
