<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id'=> fake()-> numberBetween(1,Category::query()->count()),
            'slug' => fake()->slug,
            'title' => fake()->word(),
            'body' => fake()->sentence,
            'price' => $this->faker->randomFloat('2',0,2),
        ];
    }
}
