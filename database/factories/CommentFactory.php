<?php
namespace Database\Factories;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
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
            'user_id'=> fake()-> numberBetween(1,User::query()->count()),
            'post_id'=> fake()-> numberBetween(1,Post::query()->count()),
            'body' => fake()->sentence(),
        ];
    }
}
