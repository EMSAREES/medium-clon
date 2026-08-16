<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostStoreRequest extends FormRequest
{
    /**
     * Solo usuarios autenticados pueden crear posts.
     * (La ruta ya estará protegida con middleware auth, pero
     * esto es una segunda capa de seguridad a nivel de request).
     */
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
            // image: valida que sea un archivo de imagen real.
            // max:2048 = 2MB máximo, en kilobytes.
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    /**
     * Genera automáticamente el slug a partir del título antes de
     * que el controlador reciba los datos ya "validados".
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }
}
