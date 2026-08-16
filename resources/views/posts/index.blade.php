<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        {{-- Mensaje de éxito tras crear/editar/borrar --}}
        @if (session('success'))
            <div class="bg-green-50 text-green-800 px-4 py-3 rounded-md text-sm mb-8">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($posts as $post)
            {{--
                Cada fila del feed. border-b + padding vertical simula
                el efecto de "lista separada por líneas" de Medium,
                en vez de tarjetas individuales con sombra.
            --}}
            <article class="flex items-start justify-between gap-6 py-8 {{ ! $loop->last ? 'border-b border-ink-faint' : '' }}">

                <div class="flex-1 min-w-0">
                    {{-- Autor: avatar + nombre, como la cabecera de cada post en Medium --}}
                    <a href="{{ route('users.show', $post->author) }}" class="flex items-center gap-2 mb-3 group">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-ink text-white text-xs font-medium">
                            {{ strtoupper(substr($post->author->name, 0, 1)) }}
                        </span>
                        <span class="text-sm text-ink group-hover:underline">
                            {{ $post->author->name }}
                        </span>
                    </a>

                    <a href="{{ route('posts.show', $post) }}" class="block group">
                        <h2 class="font-serif text-xl sm:text-2xl font-semibold text-ink leading-snug group-hover:text-ink-light transition-colors">
                            {{ $post->title }}
                        </h2>

                        @if ($post->excerpt)
                            <p class="text-ink-light mt-2 line-clamp-2">
                                {{ $post->excerpt }}
                            </p>
                        @endif
                    </a>

                    {{-- Metadatos: fecha, categoría, aplausos --}}
                    <div class="flex items-center gap-3 mt-4 text-xs text-ink-light">
                        <span>{{ $post->published_at->format('d M') }}</span>
                        <span class="px-2 py-0.5 bg-gray-100 rounded-full">{{ $post->category->name }}</span>
                        <span class="flex items-center gap-1">
                            👏 {{ $post->totalClaps() }}
                        </span>
                    </div>
                </div>

                {{-- Imagen de portada, pequeña y cuadrada, a la derecha
                     (solo si el post tiene una) --}}
                @if ($post->cover_image)
                    <a href="{{ route('posts.show', $post) }}" class="shrink-0">
                        <img
                            src="{{ Storage::url($post->cover_image) }}"
                            alt="{{ $post->title }}"
                            class="w-28 h-28 sm:w-32 sm:h-32 object-cover rounded"
                        >
                    </a>
                @endif
            </article>
        @empty
            <div class="text-center py-24">
                <p class="text-ink-light font-serif text-lg">
                    Todavía no hay artículos publicados.
                </p>
                @auth
                    <a href="{{ route('posts.create') }}" class="inline-block mt-4 text-accent hover:underline">
                        Escribe el primero →
                    </a>
                @endauth
            </div>
        @endforelse

        {{-- Paginación --}}
        @if ($posts->hasPages())
            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
