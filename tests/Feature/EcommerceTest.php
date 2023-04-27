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


    public function testProductListing()
    {
        $product = Product::factory()->create();

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function testAddProductToCart()
    {
        $product = Product::factory()->create();

        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('cart');
    }

    public function testCheckoutProcess()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 10]);
        $this->actingAs($user);

        // Add product to cart
        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Proceed to checkout
        $response = $this->post('/checkout', [
            'shipping_address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'payment_method' => 'credit_card',
            'card_number' => '4242424242424242',
            'expiration_date' => '12/25',
            'cvv' => '123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/order/confirmation');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'processing',
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 8,
        ]);
    }


    public function test_user_can_search_products()
    {
        $product = Product::factory()->create(['title' => 'Test']);

        $response = $this->get('?search=Test&category=&sort=');
        $response->assertStatus(200);
        $response->assertSeeText('Test');
    }



}
