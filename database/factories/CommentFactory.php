<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'user_id'=> fake()-> numberBetween(1,User::query()->get("id")->count()),
            'post_id'=> fake()-> numberBetween(1,Post::query()->get("id")->count()),
            'body' => fake()->sentence(),
        ];
    }
}
