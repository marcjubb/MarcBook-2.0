<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$u1 = new Post();
        $u1 -> name = "Jason";
        $u1 -> username = "Jason.gormo";
        $u1 -> email = "jason@gmail.com";
        $u1 -> password = "FlyAway";
        $u1 -> save();*/
        Post::factory()-> count(20) ->create();
    }
}
