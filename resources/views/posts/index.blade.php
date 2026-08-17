<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        {{-- Mensaje de éxito tras crear/editar/borrar --}}
        @if (session('success'))
            <div class="bg-green-50 text-green-800 px-4 py-3 rounded-md text-sm mb-8">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($posts as $post)
            @include('posts.partials.card', ['post' => $post])
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
