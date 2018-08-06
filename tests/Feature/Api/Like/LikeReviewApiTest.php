<?php

namespace Tests\Feature\Api;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Facades\Route;
use Tests\JwtTestCase;
use Tests\TestCase;

class LikeReviewApiTest extends JwtTestCase
{
    protected $user;
    protected $review;

    public function setUp()
    {
        parent::setUp();

        $this->actingAsJwtToken();

        $this->review = factory(Review::class)->create();
    }

    public function testLikeReviewNotFound()
    {
        $response =  $this->json('POST', "/api/v1/reviews/1000000/like", []);
        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testLikeReview()
    {
        $response =  $this->json('POST', "/api/v1/reviews/{$this->review->id}/like", []);
        $response->assertStatus(200);
    }
}