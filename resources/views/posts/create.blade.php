<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Escribir nuevo post
        </h2>
    </x-slot>

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

                    <div class="flex justify-end mt-6">
                        <x-primary-button>Publicar</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
