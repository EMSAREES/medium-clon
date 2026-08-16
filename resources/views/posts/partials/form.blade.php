{{--
    Formulario "editor" reutilizable para crear y editar posts.
    Recibe $post (null en creación, con datos en edición).
--}}

@php
    $post = $post ?? null;
@endphp

{{-- Categoría: la ponemos primero y pequeña, como un "tag" editorial,
     no como un <select> tradicional de formulario --}}
<div class="mb-6">
    <select
        id="category_id"
        name="category_id"
        class="text-xs font-medium uppercase tracking-wide text-accent bg-transparent border-0 focus:ring-0 px-0 py-0 cursor-pointer"
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
    <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
</div>

{{--
    Título: un textarea gigante sin bordes que se estira solo.
    Usamos <textarea> en vez de <input type="text"> a propósito:
    permite que títulos largos hagan salto de línea de forma natural,
    igual que en el editor real de Medium.
--}}
<div class="mb-4">
    <textarea
        id="title"
        name="title"
        rows="1"
        placeholder="Título"
        required
        autofocus
        class="w-full font-serif text-4xl font-bold text-ink placeholder-gray-300 border-0 focus:ring-0 resize-none px-0 py-0 leading-tight"
        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
    >{{ old('title', $post?->title) }}</textarea>
    <x-input-error :messages="$errors->get('title')" class="mt-1" />
</div>

{{-- Resumen corto: también sin caja, como un subtítulo --}}
<div class="mb-8">
    <input
        id="excerpt"
        name="excerpt"
        type="text"
        placeholder="Resumen corto (opcional)"
        value="{{ old('excerpt', $post?->excerpt) }}"
        class="w-full font-serif text-xl text-ink-light placeholder-gray-300 border-0 focus:ring-0 px-0 py-0"
    >
    <x-input-error :messages="$errors->get('excerpt')" class="mt-1" />
</div>

{{-- Imagen de portada: zona de carga discreta en vez de <input> plano --}}
<div class="mb-8">
    <label for="cover_image" class="block cursor-pointer">
        @if ($post?->cover_image)
            <img
                src="{{ Storage::url($post->cover_image) }}"
                alt="Portada actual"
                class="w-full max-h-64 object-cover rounded mb-2"
            >
            <span class="text-xs text-ink-light hover:text-accent">
                Cambiar imagen de portada
            </span>
        @else
            <span class="flex items-center gap-2 text-sm text-ink-light hover:text-accent w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Agregar imagen de portada
            </span>
        @endif
    </label>
    <input
        id="cover_image"
        name="cover_image"
        type="file"
        accept="image/*"
        class="hidden"
        onchange="this.closest('div').querySelector('label').classList.add('opacity-50')"
    >
    <x-input-error :messages="$errors->get('cover_image')" class="mt-1" />
</div>

{{--
    Contenido: textarea grande, sin bordes, con la misma tipografía
    serif que se usará al leer el post publicado — así el autor
    escribe "viendo" cómo se va a ver el resultado final.
--}}
<div class="mb-8">
    <textarea
        id="content"
        name="content"
        rows="15"
        placeholder="Cuenta tu historia..."
        required
        class="w-full font-serif text-lg text-ink placeholder-gray-300 border-0 focus:ring-0 resize-none px-0 py-0 leading-relaxed"
    >{{ old('content', $post?->content) }}</textarea>
    <x-input-error :messages="$errors->get('content')" class="mt-1" />
</div>
