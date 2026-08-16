<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    {{-- HTML solo entiende GET y POST en formularios reales.
                         @method('PUT') agrega un campo oculto que Laravel
                         interpreta como "esta petición es en realidad un PUT",
                         para que llegue al método update() del controlador. --}}
                    @method('PUT')

                    @include('posts.partials.form')

                    <div class="flex justify-end mt-6">
                        <x-primary-button>Guardar cambios</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
