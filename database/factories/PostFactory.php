<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=> fake()-> numberBetween(1,User::query()->count()),
            'category_id'=> fake()-> numberBetween(1,Category::query()->count()),
            'slug' => fake()->slug,
            'title' => fake()->sentence,
            'body' => fake()->sentence,
        ];
    }
}
