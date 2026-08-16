<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('posts.partials.form')

            <div class="flex items-center justify-between gap-3 pt-6 border-t border-ink-faint">
                <span class="text-xs text-ink-light">
                    @if ($post->published_at)
                        Publicado el {{ $post->published_at->format('d M, Y') }}
                    @else
                        Borrador sin publicar
                    @endif
                </span>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        name="action"
                        value="draft"
                        class="text-sm text-ink-light hover:text-ink px-4 py-2"
                    >
                        Guardar como borrador
                    </button>

                    <button
                        type="submit"
                        name="action"
                        value="publish"
                        class="text-sm bg-accent text-white px-5 py-2 rounded-full hover:bg-accent-dark transition-colors"
                    >
                        {{ $post->published_at ? 'Guardar cambios' : 'Publicar' }}
                    </button>
                </div>
            </div>

        </form>

    </div>
</x-app-layout>
