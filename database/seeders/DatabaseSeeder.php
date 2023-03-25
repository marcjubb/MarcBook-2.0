<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Factories\AffinityFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {

        $this -> call(UsersTableSeeder::class);

        $this -> call(CategoryTableSeeder::class);




        $this -> call(ProductsTableSeeder::class);


        $this -> call(AffinitiesTableSeeder::class);

        foreach (Product::all() as $post) {
            $categories = Category::all()->take(random_int(1,Category::query()->count()))->pluck('id');
            $post -> categories() -> attach($categories);
        }

    }
}
