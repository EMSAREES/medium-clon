<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        <h1 class="font-serif text-2xl font-semibold text-ink mb-1">
            @if ($query !== '')
                Resultados para "{{ $query }}"
            @else
                Todos los artículos
            @endif
        </h1>
        <p class="text-sm text-ink-light mb-8">
            {{ $posts->total() }} {{ Str::plural('artículo', $posts->total()) }} encontrado{{ $posts->total() === 1 ? '' : 's' }}
        </p>

        @forelse ($posts as $post)
            @include('posts.partials.card', ['post' => $post])
        @empty
            <div class="text-center py-24">
                <p class="text-ink-light font-serif text-lg">
                    No encontramos artículos que coincidan con "{{ $query }}".
                </p>
                <a href="{{ route('posts.index') }}" class="inline-block mt-4 text-accent hover:underline">
                    Ver todos los artículos →
                </a>
            </div>
        @endforelse

        @if ($posts->hasPages())
            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
