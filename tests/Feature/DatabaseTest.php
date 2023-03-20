<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_model_exists_in_database()
    {


        $user = User::factory()->create();

        $this->assertModelExists($user);

    }
}
