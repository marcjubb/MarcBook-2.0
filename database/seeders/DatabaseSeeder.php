<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this -> call(UsersTableSeeder::class);

        $this -> call(PostsTableSeeder::class);

        $this -> call(CommentsTableSeeder::class);
        /*$user = User::factory()-> create();


        $post = Post::factory()->create([
            'user_id'=> $user -> id
        ]);

       Comment::factory(5)->create([
            'user_id'=> $user -> id,
            'post_id'=> $post -> id,
        ]);*/

    }
}
