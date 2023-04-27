<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecommendtionTest extends TestCase
{

    public function testRecommendationsGeneratedForUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate user interactions with products
        // ...

        $response = $this->get('/recommendations');

        $response->assertStatus(200);
        $response->assertViewHas('recommendations');
        $this->assertNotEmpty($response->viewData('recommendations'));
    }
    public function testRecommendationRelevancy()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate user interactions with products and set user preferences
        // ...

        $response = $this->get('/recommendations');

        $recommendations = $response->viewData('recommendations');
        $relevant = $this->checkRelevancy($recommendations, $user);

        $this->assertTrue($relevant);
    }

    private function checkRelevancy($recommendations, $user)
    {
        // Retrieve user preferences or interaction history
        $userPreferences = $user->preferences; // Retrieve user preferences from database

        // Calculate the similarity between recommendations and user preferences
        $relevantCount = 0;
        foreach ($recommendations as $recommendedProduct) {
            if ($this->isProductRelevant($recommendedProduct, $userPreferences)) {
                $relevantCount++;
            }
        }

        // Check if the majority of the recommendations are relevant
        $relevantPercentage = $relevantCount / count($recommendations);
        return $relevantPercentage > 0.5;
    }

    private function isProductRelevant($product, $userPreferences)
    {

        return in_array($product->category, $userPreferences->categories, true);
    }

    public function testRecommendationUpdatingCycle()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate user interactions with products
        // ...

        $response1 = $this->get('/recommendations');
        sleep(300); // Wait for 5 minutes
        $response2 = $this->get('/recommendations');

        $this->assertNotEquals($response1->viewData('recommendations'), $response2->viewData('recommendations'));
    }


}
#
