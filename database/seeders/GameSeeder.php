<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        Game::factory(50)->create();
        
        // Buat beberapa game featured
        Game::factory(5)->create([
            'is_featured' => true,
        ]);
        
        // Buat beberapa game new release
        Game::factory(8)->create([
            'is_new_release' => true,
            'release_date' => now()->subDays(rand(1, 30)),
        ]);
        
        // Buat beberapa bestseller
        Game::factory(6)->create([
            'is_bestseller' => true,
            'user_rating' => rand(45, 50) / 10,
        ]);

        Game::factory(5)->create([
            'is_comming_soon' => true,
        ]);
    }
}