<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition(): array
    {
        $genres = ['Action', 'Adventure', 'RPG', 'Strategy', 'Simulation', 'Sports', 'Racing', 'Puzzle', 'Horror', 'Indie'];
        $developers = ['Mythic Studios', 'Epic Games', 'Valve Corporation', 'Ubisoft', 'EA Games', 'Activision', 'Bethesda'];
        $ratings = ['E', 'T', 'M'];
        
        $price = $this->faker->randomFloat(2, 10000, 1000000);
        $hasDiscount = $this->faker->boolean(30);
        $discountPercentage = $hasDiscount ? $this->faker->numberBetween(10, 75) : null;
        $discountPrice = $hasDiscount ? $price * (1 - $discountPercentage / 100) : null;

        return [
            'title' => $this->faker->words(3, true) . ' ' . $this->faker->randomElement(['Quest', 'Adventure', 'Legends', 'Chronicles', 'Saga', 'Wars']),
            'description' => $this->faker->paragraphs(3, true),
            'short_description' => $this->faker->sentence(15),
            'price' => $price,
            'discount_price' => $discountPrice,
            'discount_percentage' => $discountPercentage,
            'image_url' => 'https://picsum.photos/800/600?random=' . $this->faker->numberBetween(1, 1000),
            'screenshots' => [
                'https://picsum.photos/1920/1080?random=' . $this->faker->numberBetween(1001, 1010),
                'https://picsum.photos/1920/1080?random=' . $this->faker->numberBetween(1011, 1020),
                'https://picsum.photos/1920/1080?random=' . $this->faker->numberBetween(1021, 1030),
            ],
            'genres' => $this->faker->randomElements($genres, $this->faker->numberBetween(1, 3)),
            'developer' => $this->faker->randomElement($developers),
            'publisher' => $this->faker->randomElement($developers),
            'release_date' => $this->faker->dateTimeBetween('-2 years', '+6 months'),
            'rating' => $this->faker->randomElement($ratings),
            'user_rating' => $this->faker->randomFloat(1, 3.0, 5.0),
            'is_featured' => $this->faker->boolean(20),
            'is_new_release' => $this->faker->boolean(15),
            'is_bestseller' => $this->faker->boolean(10),
            'is_comming_soon' => $this->faker->boolean(10), 
        ];
    }
}