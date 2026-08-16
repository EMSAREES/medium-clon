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
                        Por <span class="font-medium">{{ $post->author->name }}</span>
                        en
                        <span class="font-medium">{{ $post->category->name }}</span>
                    </div>
                    <div>{{ $post->published_at->format('d M, Y') }}</div>
                </div>

                {{-- nl2br + e(): convierte saltos de línea en <br> de forma
                     segura, escapando el contenido para evitar inyección
                     de HTML/JS malicioso (XSS) escrito por el autor. --}}
                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>

                {{--
                    @can es la versión Blade de $user->can('update', $post).
                    Internamente consulta la PostPolicy que creamos en la
                    Etapa 6.5. Si el usuario logueado no es el autor,
                    este bloque completo ni siquiera se renderiza.
                --}}
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
