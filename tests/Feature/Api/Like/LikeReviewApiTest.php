<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class LikeReviewApiTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $review;

    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        $this->token = \JWTAuth::fromUser($this->user);
        $this->review = factory(Review::class)->create();
    }

    public function testLikeReviewNotFound()
    {
        $response = $this->post(
            "/api/v1/reviews/99999/like",
            [],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testLikeReview()
    {
        $response = $this->post(
            "/api/v1/reviews/{$this->review->id}/like",
            [],
            ['Authorization' => 'Bearer ' . $this->token]
        );
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $this->review->id,
            'likeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }
}