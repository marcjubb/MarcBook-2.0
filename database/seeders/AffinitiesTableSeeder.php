<?php

namespace Database\Seeders;
use App\Models\Affinity;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class AffinitiesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {

        Affinity::factory()->count(200)->create();
    }
}
