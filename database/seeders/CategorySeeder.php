<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Categorías fijas del proyecto, similares a las secciones
     * reales de Medium. No usamos factory porque estas categorías
     * son controladas por nosotros, no datos aleatorios.
     */
    public function run(): void
    {
        $categories = [
            'Tecnología',
            'Programación',
            'Diseño',
            'Negocios',
            'Productividad',
            'Ciencia',
            'Salud y bienestar',
            'Cultura',
        ];

        foreach ($categories as $name) {
            // updateOrCreate evita duplicados si corres el seeder
            // más de una vez: busca por "slug" y actualiza el
            // nombre si ya existe, en vez de crear una fila nueva.
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
