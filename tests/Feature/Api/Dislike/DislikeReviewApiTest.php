<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class DislikeReviewApiTest extends ApiTestCase
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

    public function testDislikeReviewNotFound()
    {
        $user = factory(User::class)->create();
        $token = \JWTAuth::fromUser($user);

        $response = $this->post('/api/v1/reviews/99999/dislike', [], ['Authorization' => 'Bearer ' . $token]);

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testDislikeReview()
    {
        $response = $this->post(
            "/api/v1/reviews/{$this->review->id}/dislike",
            [],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertStatus(200);
        $this->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $this->review->id,
            'dislikeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }
}