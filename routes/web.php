<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClapController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', '/posts');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas del CRUD de posts.
// "posts.index" (GET /posts), "posts.show" (GET /posts/{post}), etc.
// se generan automáticamente con nombres tipo "posts.create", "posts.store"...
Route::resource('posts', PostController::class);

Route::post('/posts/{post}/claps', [ClapController::class, 'store'])
    ->middleware('auth')
    ->name('posts.claps.store');

// Perfil público — cualquiera puede verlo, sin login.
Route::get('/u/{user}', [UserProfileController::class, 'show'])->name('users.show');

// Seguir / dejar de seguir — requieren estar logueado.
Route::post('/u/{user}/follow', [FollowController::class, 'store'])
    ->middleware('auth')
    ->name('users.follow');

Route::delete('/u/{user}/follow', [FollowController::class, 'destroy'])
    ->middleware('auth')
    ->name('users.unfollow');

require __DIR__.'/auth.php';
