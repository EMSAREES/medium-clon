<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Categorías fijas primero (los posts las necesitan).
        $this->call(CategorySeeder::class);

        // 2. Un usuario de prueba con credenciales conocidas,
        //    para poder iniciar sesión sin adivinar contraseñas random.
        $mainUser = User::factory()->create([
            'name' => 'Usuario de prueba',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 3. 14 usuarios más, con datos completamente aleatorios.
        $otherUsers = User::factory(14)->create();

        $allUsers = $otherUsers->push($mainUser);
        $categoryIds = \App\Models\Category::pluck('id');

        // 4. Posts: cada usuario escribe entre 2 y 5 posts, usando
        //    SIEMPRE una categoría real (no la factory aleatoria).
        $allUsers->each(function (User $user) use ($categoryIds) {
            Post::factory()
                ->count(rand(2, 5))
                ->create([
                    'user_id' => $user->id,
                    'category_id' => fn () => $categoryIds->random(),
                ]);
        });

        // 5. Claps: cada usuario aplaude entre 0 y 8 posts random
        //    (que no sean suyos, para que tenga más sentido).
        $allPosts = Post::all();

        $allUsers->each(function (User $user) use ($allPosts) {
            $postsToClaap = $allPosts
                ->where('user_id', '!=', $user->id)
                ->random(min(rand(0, 8), $allPosts->count() - 1));

            // Cuando random() recibe 1, devuelve un modelo suelto
            // en vez de una colección — collect() normaliza ambos casos.
            collect([$postsToClaap])->flatten()->each(function ($post) use ($user) {
                $post->claps()->create([
                    'user_id' => $user->id,
                    'count' => rand(1, 50),
                ]);
            });
        });

        // 6. Follows: cada usuario sigue entre 1 y 5 personas al azar
        //    (que no sea él mismo).
        $allUsers->each(function (User $user) use ($allUsers) {
            $toFollow = $allUsers
                ->where('id', '!=', $user->id)
                ->random(min(rand(1, 5), $allUsers->count() - 1));

            $user->following()->syncWithoutDetaching(
                collect([$toFollow])->flatten()->pluck('id')
            );
        });
    }
}
