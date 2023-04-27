<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EcommerceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'Teser',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('');
    }

    public function testUserLogin()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'testpassword'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('');
    }

    public function testUserLogout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/');

    }




}
