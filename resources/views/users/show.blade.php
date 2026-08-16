<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        @if (session('success'))
            <div class="bg-green-50 text-green-800 px-4 py-3 rounded-md text-sm mb-8">
                {{ session('success') }}
            </div>
        @endif

        {{-- Cabecera del perfil: avatar grande + info, sin "tarjeta" con sombra --}}
        <div class="flex flex-col items-center text-center border-b border-ink-faint pb-8 mb-8">

            {{-- Avatar grande con la inicial del nombre --}}
            <span class="flex items-center justify-center w-20 h-20 rounded-full bg-ink text-white text-2xl font-medium mb-4">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </span>

            <h1 class="font-serif text-3xl font-bold text-ink mb-2">
                {{ $user->name }}
            </h1>

            <p class="text-sm text-ink-light mb-6">
                {{ $user->following->count() }} siguiendo
                <span class="mx-1">·</span>
                {{ $user->followers->count() }} seguidores
            </p>

            {{--
                Botón de seguir/dejar de seguir. Misma lógica que antes,
                solo con el estilo de pastilla (rounded-full) que ya
                usamos en el resto del rediseño.
            --}}
            @auth
                @if (auth()->id() !== $user->id)
                    @if (auth()->user()->following->contains($user->id))
                        <form method="POST" action="{{ route('users.unfollow', $user) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-5 py-2 rounded-full border border-ink-faint text-sm font-medium text-ink hover:border-red-400 hover:text-red-600 transition-colors"
                            >
                                Dejar de seguir
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('users.follow', $user) }}">
                            @csrf
                            <button
                                type="submit"
                                class="px-5 py-2 rounded-full bg-accent text-white text-sm font-medium hover:bg-accent-dark transition-colors"
                            >
                                Seguir
                            </button>
                        </form>
                    @endif
                @endif
            @endauth
        </div>

        {{-- Feed de posts del usuario, mismo patrón visual que posts.index --}}
        @forelse ($user->posts as $post)
            <article class="flex items-start justify-between gap-6 py-8 {{ ! $loop->last ? 'border-b border-ink-faint' : '' }}">

                <div class="flex-1 min-w-0">
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
        @empty
            <p class="text-ink-light text-center py-16 font-serif">
                {{ $user->name }} todavía no ha publicado nada.
            </p>
        @endforelse

    </div>
</x-app-layout>
