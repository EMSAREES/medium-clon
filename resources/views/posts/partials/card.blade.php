{{--
    Tarjeta de post reutilizada en el feed (posts.index), en el
    perfil de usuario (users.show) y en resultados de búsqueda
    (search.index). Recibe $post y el booleano opcional
    $showAuthor (por defecto true) para ocultar el autor cuando
    ya sabemos de quién son todos los posts, como en el perfil.
--}}
@php
    $showAuthor = $showAuthor ?? true;
@endphp

<article class="flex items-start justify-between gap-6 py-8 {{ ! $loop->last ? 'border-b border-ink-faint' : '' }}">

    <div class="flex-1 min-w-0">
        @if ($showAuthor)
            <a href="{{ route('users.show', $post->author) }}" class="flex items-center gap-2 mb-3 group">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-ink text-white text-xs font-medium">
                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                </span>
                <span class="text-sm text-ink group-hover:underline">
                    {{ $post->author->name }}
                </span>
            </a>
        @endif

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

        <div class="flex items-center gap-3 mt-4 text-xs text-ink-light">
            <span>{{ $post->published_at->format('d M') }}</span>
            <span class="px-2 py-0.5 bg-gray-100 rounded-full">{{ $post->category->name }}</span>
            <span class="flex items-center gap-1">👏 {{ $post->totalClaps() }}</span>
        </div>
    </div>

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
