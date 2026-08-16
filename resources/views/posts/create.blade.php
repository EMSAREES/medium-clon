<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf

            @include('posts.partials.form')

            {{-- Botones de acción, como una barra flotante al final --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-ink-faint">
                <button
                    type="submit"
                    name="action"
                    value="draft"
                    class="text-sm text-ink-light hover:text-ink px-4 py-2"
                >
                    Guardar borrador
                </button>

                <button
                    type="submit"
                    name="action"
                    value="publish"
                    class="text-sm bg-accent text-white px-5 py-2 rounded-full hover:bg-accent-dark transition-colors"
                >
                    Publicar
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
