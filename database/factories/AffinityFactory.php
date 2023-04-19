<?php

namespace Database\Factories;

use App\Models\Affinity;
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
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'product_id' => $this->faker->numberBetween(1, Product::count()),
            'score' => $this->faker->numberBetween(1, 5),
            'time' => $this->faker->unique()->numberBetween(1, 50000),
        ];
    }

    /**
     * Indicate that the combination of user_id and product_id should be unique.
     *
     * @return Factory
     */
    public function configure(): Factory
    {
        return $this->afterCreating(function ($affinity) {
            $unique = false;
            while (!$unique) {
                $unique = !Affinity::where([
                    'user_id' => $affinity->user_id,
                    'product_id' => $affinity->product_id,
                ])->exists();

                if (!$unique) {
                    $affinity->product_id = $this->faker->numberBetween(1, Product::count());
                    $affinity->user_id = $this->faker->numberBetween(1, User::count());
                }
            }
        });
    }
}
