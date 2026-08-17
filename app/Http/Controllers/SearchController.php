<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Busca posts publicados cuyo título, resumen o contenido
     * coincidan con el término de búsqueda ($q).
     */
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q'));

        $posts = Post::query()
            ->with(['author', 'category'])
            ->whereNotNull('published_at')
            ->when($query !== '', function ($builder) use ($query) {
                // where(...) con un Closure agrupa las condiciones con
                // paréntesis: (title ILIKE ? OR excerpt ILIKE ? OR content ILIKE ?)
                // Esto es importante para que no se mezcle mal con el
                // whereNotNull('published_at') de arriba.
                $builder->where(function ($builder) use ($query) {
                    $term = "%{$query}%";

                    // ILIKE es específico de PostgreSQL: como LIKE pero
                    // sin distinguir mayúsculas/minúsculas.
                    $builder->where('title', 'ilike', $term)
                        ->orWhere('excerpt', 'ilike', $term)
                        ->orWhere('content', 'ilike', $term);
                });
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString(); // conserva ?q=... al cambiar de página

        return view('search.index', compact('posts', 'query'));
    }
}
