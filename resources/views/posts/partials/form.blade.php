{{--
    Formulario reutilizable para crear y editar posts.
    Recibe una variable $post: si viene null (creación), los campos
    están vacíos; si viene con datos (edición), los precarga.
--}}

@php
    // isset()/null-safe: si $post no existe en este contexto (create),
    // lo tratamos como null para no romper el resto del formulario.
    $post = $post ?? null;
@endphp

{{-- Título --}}
<div class="mb-4">
    <x-input-label for="title" value="Título" />
    <x-text-input
        id="title"
        name="title"
        type="text"
        class="mt-1 block w-full"
        :value="old('title', $post?->title)"
        required
        autofocus
    />
    {{-- old() recupera el valor enviado si la validación falló y
         Laravel nos devolvió al formulario. $post?->title es el
         "operador nullsafe": si $post es null, no truena, devuelve null. --}}
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

{{-- Categoría --}}
<div class="mb-4">
    <x-input-label for="category_id" value="Categoría" />
    <select
        id="category_id"
        name="category_id"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        required
    >
        <option value="">Selecciona una categoría</option>
        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected(old('category_id', $post?->category_id) == $category->id)
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

{{-- Resumen corto --}}
<div class="mb-4">
    <x-input-label for="excerpt" value="Resumen (opcional)" />
    <x-text-input
        id="excerpt"
        name="excerpt"
        type="text"
        class="mt-1 block w-full"
        :value="old('excerpt', $post?->excerpt)"
    />
    <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
</div>

{{-- Contenido --}}
<div class="mb-4">
    <x-input-label for="content" value="Contenido" />
    <textarea
        id="content"
        name="content"
        rows="10"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        required
    >{{ old('content', $post?->content) }}</textarea>
    <x-input-error :messages="$errors->get('content')" class="mt-2" />
</div>

{{-- Imagen de portada --}}
<div class="mb-4">
    <x-input-label for="cover_image" value="Imagen de portada (opcional)" />

    @if ($post?->cover_image)
        <img
            src="{{ Storage::url($post->cover_image) }}"
            alt="Portada actual"
            class="mt-2 mb-2 h-32 w-auto rounded object-cover"
        >
        <p class="text-sm text-gray-500 mb-2">Sube una nueva imagen solo si quieres reemplazar la actual.</p>
    @endif

    <input
        id="cover_image"
        name="cover_image"
        type="file"
        accept="image/*"
        class="mt-1 block w-full text-sm text-gray-600"
    >
    <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
</div>
