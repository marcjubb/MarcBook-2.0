<?php

namespace Database\Factories;

use App\Models\BasketItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class BasketItemFactory extends Factory
{
    protected $model = BasketItem::class;

    public function definition()
    {
        return [
            'user_id'=> fake()-> numberBetween(User::query()->first()->id,User::query()->count()),
            'product_id'=> fake()-> numberBetween(Product::query()->first()->id,Product::query()->count()),
            'quantity' => $this->faker->numberBetween(1, 6),
        ];
    }
}
