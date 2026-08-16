<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Escribir nuevo post
        </h2>
    </x-slot>

    @if (is_null($post->published_at))
        <div class="bg-yellow-50 border-b border-yellow-200">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 py-3">
                <p class="text-sm text-yellow-800">
                    📝 Este post es un <strong>borrador</strong> — solo tú puedes verlo.
                </p>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                {{--
                    enctype="multipart/form-data" es OBLIGATORIO cuando
                    el formulario incluye un <input type="file">.
                    Sin esto, la imagen simplemente no llega al servidor.
                --}}
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- @csrf inserta un token oculto que protege contra
                         ataques de tipo CSRF (Cross-Site Request Forgery).
                         Toda petición POST/PUT/DELETE en Laravel lo requiere. --}}

                    @include('posts.partials.form')

                    <div class="flex justify-end gap-3 mt-6">
                        <button
                            type="submit"
                            name="action"
                            value="draft"
                            class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Guardar borrador
                        </button>

                        <x-primary-button type="submit" name="action" value="publish">
                            Publicar
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
