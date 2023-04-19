<?php

namespace Database\Seeders;
use App\Models\Affinity;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {

        Image::factory()->count(200)->create();
    }
}
