<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class AffinityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=> fake()-> numberBetween(User::query()->first()->id,User::query()->count()),
            'product_id'=> fake()-> numberBetween(Product::query()->first()->id,Product::query()->count()),
            'score'=> fake()-> numberBetween(1,5),
            'time'=> fake() -> unique()->numberBetween(1,50000)
        ];
    }
}
