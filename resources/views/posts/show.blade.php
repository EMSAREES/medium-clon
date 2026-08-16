<x-app-layout>

    {{-- Aviso de borrador: mismo bloque de antes, con nuevos colores --}}
    @if (is_null($post->published_at))
        <div class="bg-amber-50 border-b border-amber-200">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 py-3">
                <p class="text-sm text-amber-800">
                    📝 Este post es un <strong>borrador</strong> — solo tú puedes verlo.
                </p>
            </div>
        </div>
    @endif

    <article class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        {{-- Categoría, como una pequeña etiqueta editorial --}}

            href="{{ route('posts.index') }}"
            class="inline-block text-xs font-medium text-accent uppercase tracking-wide mb-4 hover:underline"
        >
            {{ $post->category->name }}
        </a>

        {{-- Título grande en serif: el elemento más "Medium" de toda la vista --}}
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-ink leading-tight mb-4">
            {{ $post->title }}
        </h1>

        @if ($post->excerpt)
            <p class="text-xl text-ink-light font-serif leading-snug mb-6">
                {{ $post->excerpt }}
            </p>
        @endif

        {{-- Autor + fecha, con avatar --}}
        <div class="flex items-center justify-between border-y border-ink-faint py-4 mb-8">
            <a href="{{ route('users.show', $post->author) }}" class="flex items-center gap-3 group">
                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-ink text-white text-sm font-medium">
                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                </span>
                <div>
                    <div class="text-sm font-medium text-ink group-hover:underline">
                        {{ $post->author->name }}
                    </div>
                    <div class="text-xs text-ink-light">
                        {{ $post->published_at?->format('d \d\e F, Y') ?? 'Sin publicar' }}
                    </div>
                </div>
            </a>

            {{-- Editar/Eliminar: ahora como iconos discretos, solo visibles para el autor --}}
            @can('update', $post)
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('posts.edit', $post) }}" class="text-ink-light hover:text-ink">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                          onsubmit="return confirm('¿Seguro que quieres eliminar este post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-ink-light hover:text-red-600">
                            Eliminar
                        </button>
                    </form>
                </div>
            @endcan
        </div>

        {{-- Imagen de portada a todo ancho --}}
        @if ($post->cover_image)
            <img
                src="{{ Storage::url($post->cover_image) }}"
                alt="{{ $post->title }}"
                class="w-full rounded mb-10"
            >
        @endif

        {{--
            Cuerpo del artículo. La clase "prose" (del plugin typography)
            aplica automáticamente buen interlineado, tamaños de párrafo,
            espaciado entre bloques, etc. — "prose-lg" lo hace un poco
            más grande, más cómodo para leer un artículo largo.
            font-serif hereda a todo el bloque, como en Medium.
        --}}
        <div class="prose prose-lg font-serif max-w-none text-ink prose-headings:font-serif">
            {!! nl2br(e($post->content)) !!}
        </div>

        {{-- Barra de aplausos, estilo "pastilla" flotante --}}
        <div class="flex items-center gap-4 mt-12 pt-8 border-t border-ink-faint">
            <form method="POST" action="{{ route('posts.claps.store', $post) }}">
                @csrf
                <button
                    type="submit"
                    @disabled(! auth()->check())
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full border border-ink-faint text-sm font-medium text-ink hover:border-accent hover:text-accent transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:border-ink-faint disabled:hover:text-ink"
                >
                    <span class="text-lg">👏</span>
                    <span>{{ $post->totalClaps() }}</span>
                </button>
            </form>

            @auth
                @if ($post->clapsFromUser(auth()->user()) > 0)
                    <span class="text-xs text-ink-light">
                        Tú diste {{ $post->clapsFromUser(auth()->user()) }}
                    </span>
                @endif
            @endauth

            @guest
                <span class="text-xs text-ink-light">
                    <a href="{{ route('login') }}" class="text-accent hover:underline">Inicia sesión</a>
                    para aplaudir
                </span>
            @endguest
        </div>

    </article>
</x-app-layout>
