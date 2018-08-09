<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class DislikeReviewApiTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $review;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        
        $this->review = factory(Review::class)->create();
        $this->user = factory(User::class)->create();
    }

    public function testDislikeReviewNotFound()
    {
        $response = $this->actingWithToken()->post(
            "/api/v1/reviews/99999/dislike"
        );

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testDislikeReview()
    {
        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/dislike"
        );

        $response->assertStatus(200);
        $this->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $this->review->id,
            'dislikeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }

    public function testDoubleDislikeReview()
    {
        $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/dislike"
        );

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/dislike"
        );
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $this->review->id,
            'dislikeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }

    public function testDislikeAfterLikeReview()
    {
        $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/like"
        );

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/dislike"
        );
        
        $response->assertStatus(200);
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $this->review->id,
            'likeable_type' => Review::class,
            'user_id' => $this->user->id
        ])->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $this->review->id,
            'dislikeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }
}
