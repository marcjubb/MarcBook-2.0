<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
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
        $post = Post::query()->first();
        $response = $this->get('/');
        $response->assertSee($post->title);
    }
    public function test_user_can_view_categories()
    {
        $category = Category::query()->first();
        $response = $this->get('/');
        $response->assertSee($category->name);
    }
    public function test_user_can_login()
    {
        $category = Category::query()->first();
        $response = $this->get('/');
        $response->assertSee($category->name);
    }
}
