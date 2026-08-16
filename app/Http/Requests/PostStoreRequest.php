<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'max:2048'],

            // Agregado: sin esto, $request->validated() descarta
            // el slug aunque lo hayamos generado en prepareForValidation().
            'slug' => ['required', 'string', 'unique:posts,slug'],
        ];
    }

    /**
     * Mensajes de error personalizados, en español, para cada regla.
     * La clave sigue el formato "campo.regla".
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede tener más de :max caracteres.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'content.required' => 'El contenido del post es obligatorio.',
            'cover_image.image' => 'El archivo debe ser una imagen (jpg, png, etc).',
            'cover_image.max' => 'La imagen no puede pesar más de 2MB.',
            'slug.unique' => 'Ya existe un post con un título muy similar. Prueba con otro título.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }
}
