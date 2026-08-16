<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * El constructor aplica middleware a TODOS los métodos excepto
     * los que dejamos explícitamente públicos con "except".
     * Así, cualquiera puede ver posts (index/show), pero solo un
     * usuario logueado puede crear/editar/borrar.
     */
    // public function __construct()
    // {
    //     $this->middleware('auth')->except(['index', 'show']);
    // }

    /**
     * Reemplaza al viejo $this->middleware() de versiones anteriores.
     * Debe ser static y devolver un array de Middleware.
     * "except" funciona igual que antes: excluye index y show,
     * que quedan públicos para cualquier visitante.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
        ];
    }

    /**
     * Listado público de posts publicados, con su autor y categoría
     * ya cargados (evita el problema N+1 al mostrarlos en la vista).
     */
    public function index(): View
    {
        $posts = Post::with(['author', 'category'])
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Formulario de creación. Necesita la lista de categorías
     * para el <select> del formulario.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('posts.create', compact('categories'));
    }

    /**
     * Guarda un post nuevo. $request ya llega validado gracias a
     * PostStoreRequest (si algo falla, Laravel redirige de vuelta
     * automáticamente con los errores, antes de llegar aquí).
     */
    public function store(PostStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            // Guarda el archivo en storage/app/public/posts
            // y devuelve la ruta relativa, ej: "posts/archivo.jpg"
            $data['cover_image'] = $request->file('cover_image')
                ->store('posts', 'public');
        }

        $post = $request->user()->posts()->create([
            ...$data,
            'published_at' => now(),
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post publicado correctamente.');
    }

    /**
     * Vista pública de un post individual.
     */
    public function show(Post $post): View
    {
        $post->load(['author', 'category']);

        return view('posts.show', compact('post'));
    }

    /**
     * Formulario de edición. Solo el autor puede llegar aquí
     * (lo reforzamos también con autorización en el próximo paso).
     */
    public function edit(Post $post): View
    {
        // Lanza un error 403 (Forbidden) automáticamente si el usuario
        // logueado no es el autor del post.
        $this->authorize('update', $post);

        $categories = Category::orderBy('name')->get();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('posts', 'public');
        }

        $post->update($data);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post actualizado correctamente.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post eliminado correctamente.');
    }
}
