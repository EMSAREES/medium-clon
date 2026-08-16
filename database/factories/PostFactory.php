<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * Una Factory en Laravel es una clase que define cómo generar datos
 * falsos o de prueba para un modelo de Eloquent. Se usa en seeders y tests
 * para poblar la base de datos con información realista de manera automática.
 */

/**
 * @extends Factory<Post>
 */
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        // sentence() con un número random de palabras, para que los
        // títulos no se sientan todos igual de largos.
        $title = fake()->sentence(rand(4, 8));

        return [
            // Por defecto, cada post creado con la factory queda
            // asignado a un usuario y categoría NUEVOS y aleatorios.
            // El seeder los sobreescribirá para reusar los que ya existen.
            'user_id' => User::factory(),
            'category_id' => Category::factory(),

            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 100000),
            'excerpt' => fake()->sentence(15),

            // paragraphs(): varios párrafos, unidos con doble salto
            // de línea, para que se vea como contenido real de artículo.
            'content' => implode("\n\n", fake()->paragraphs(6)),

            // 80% de probabilidad de estar publicado, 20% como borrador.
            'published_at' => fake()->boolean(80)
                ? fake()->dateTimeBetween('-6 months', 'now')
                : null,
        ];
    }

    /**
     * State personalizado: fuerza que el post sea un borrador.
     * Uso: Post::factory()->draft()->create()
     */
    public function draft(): static
    {
        return $this->state(fn () => ['published_at' => null]);
    }

    /**
     * State personalizado: fuerza que el post esté publicado.
     * Uso: Post::factory()->published()->create()
     */
    public function published(): static
    {
        return $this->state(fn () => ['published_at' => fake()->dateTimeBetween('-6 months', 'now')]);
    }
}
