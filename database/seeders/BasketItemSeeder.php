<?php

namespace Database\Seeders;

use App\Models\BasketItem;
use Illuminate\Database\Seeder;

class BasketItemSeeder extends Seeder
{
    public function run()
    {
        BasketItem::factory()->count(20)->create();
    }
}
