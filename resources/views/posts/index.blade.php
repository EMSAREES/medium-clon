<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Artículos
            </h2>

            @auth

                    href="{{ route('posts.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700"
                >
                    Escribir post
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Mensaje de éxito tras crear/editar/borrar (session('success')
                 lo puso el controlador con ->with('success', '...')). --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($posts as $post)
                <article class="bg-white p-6 shadow sm:rounded-lg">
                    <a href="{{ route('posts.show', $post) }}" class="block">
                        <h3 class="text-lg font-semibold text-gray-900 hover:text-indigo-600">
                            {{ $post->title }}
                        </h3>
                    </a>

                    @if ($post->excerpt)
                        <p class="text-gray-600 mt-2">{{ $post->excerpt }}</p>
                    @endif

                    <div class="text-sm text-gray-500 mt-4">
                        {{ $post->author->name }} · {{ $post->category->name }}
                        · {{ $post->published_at->diffForHumans() }}
                    </div>
                </article>
            @empty
                <p class="text-gray-500 text-center py-12">
                    Todavía no hay posts publicados.
                </p>
            @endforelse

            {{-- Los links de paginación (anterior/siguiente) vienen
                 automáticos porque en el controlador usamos ->paginate(10)
                 en vez de ->get(). --}}
            <div>
                {{ $posts->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
