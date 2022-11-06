<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$u1 = new User();
        $u1 -> name = "Jason";
        $u1 -> username = "Jason.gormo";
        $u1 -> email = "jason@gmail.com";
        $u1 -> password = "FlyAway";
        $u1 -> save();*/
       User::factory()-> count(5) ->create();

    }
}
