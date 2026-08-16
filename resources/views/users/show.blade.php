<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Cabecera del perfil --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $user->following->count() }} siguiendo
                            ·
                            {{ $user->followers->count() }} seguidores
                        </p>
                    </div>

                    {{--
                        Solo mostramos el botón de seguir si:
                        1. Hay alguien logueado (@auth)
                        2. No es su propio perfil
                    --}}
                    @auth
                        @if (auth()->id() !== $user->id)
                            @if (auth()->user()->following->contains($user->id))
                                <form method="POST" action="{{ route('users.unfollow', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                    >
                                        Dejar de seguir
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('users.follow', $user) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700"
                                    >
                                        Seguir
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Posts publicados de este usuario --}}
            <div class="space-y-4">
                @forelse ($user->posts as $post)
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
                            {{ $post->category->name }} · {{ $post->published_at->diffForHumans() }}
                        </div>
                    </article>
                @empty
                    <p class="text-gray-500 text-center py-12">
                        {{ $user->name }} todavía no ha publicado nada.
                    </p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
