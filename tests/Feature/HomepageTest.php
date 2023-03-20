<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_view_post()
    {
        $post = Product::query()->latest();
        $response = $this->get('/');
        $response->assertSee($post->title);
    }
    public function test_user_can_view_categories()
    {
        $category = Category::query()->first();
        $response = $this->get('/');
        $response->assertSee($category->name);
    }

}
