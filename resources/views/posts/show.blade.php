<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                @if ($post->cover_image)
                    <img
                        src="{{ Storage::url($post->cover_image) }}"
                        alt="{{ $post->title }}"
                        class="w-full h-64 object-cover rounded mb-6"
                    >
                @endif

                <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                    <div>
                        Por <a href="{{ route('users.show', $post->author) }}" class="font-medium text-indigo-600 hover:underline">
                            {{ $post->author->name }}
                        </a>
                        en
                        <span class="font-medium">{{ $post->category->name }}</span>
                    </div>
                    <div>{{ $post->published_at->format('d M, Y') }}</div>
                </div>

                {{-- Bloque de "claps" (aplausos) --}}
                <div class="flex items-center gap-4 mb-6 pb-6 border-b">
                    <form method="POST" action="{{ route('posts.claps.store', $post) }}">
                        @csrf
                        <button
                            type="submit"
                            @disabled(! auth()->check())
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            👏 Aplaudir
                        </button>
                    </form>

                    <span class="text-sm text-gray-500">
                        {{ $post->totalClaps() }} {{ Str::plural('aplauso', $post->totalClaps()) }}
                    </span>

                    @auth
                        @if ($post->clapsFromUser(auth()->user()) > 0)
                            <span class="text-xs text-gray-400">
                                (tú diste {{ $post->clapsFromUser(auth()->user()) }})
                            </span>
                        @endif
                    @endauth

                    @guest
                        <span class="text-xs text-gray-400">
                            <a href="{{ route('login') }}" class="underline">Inicia sesión</a> para aplaudir
                        </span>
                    @endguest
                </div>

                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>

                @can('update', $post)
                    <div class="flex gap-3 mt-8 pt-6 border-t">

                            href="{{ route('posts.edit', $post) }}"
                            class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                        >
                            Editar
                        </a>

                        <form method="POST" action="{{ route('posts.destroy', $post) }}"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                Eliminar
                            </button>
                        </form>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
