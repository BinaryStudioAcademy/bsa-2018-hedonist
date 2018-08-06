<?php

namespace Tests\Feature\Api;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Facades\Route;

class LikeReviewApiTest extends ApiTestCase
{
    private $user;
    private $review;
    private $credentials;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->review = factory(Review::class)->create();
        $this->credentials = auth()->login($this->user);
    }

    public function testLikeReviewNotFound()
    {
        $response =  $this->json(
            'POST',
            "/api/v1/reviews/1000000/like",
            [],
            ['HTTP_Authorization' => 'Bearer ' . $this->credentials]
        );
        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testLikeReview()
    {
        $response =  $this->json(
            'POST',
            "/api/v1/reviews/{$this->review->id}/like",
            [],
            ['HTTP_Authorization' => 'Bearer ' . $this->credentials]
        );
        $response->assertStatus(200);
    }
}