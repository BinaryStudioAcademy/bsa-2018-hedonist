<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Like\Like;
use Hedonist\Entities\Dislike\Dislike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class LikeReviewApiTest extends ApiTestCase
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

    public function testLikeReviewNotFound()
    {
        $response = $this->actingWithToken()->post(
            "/api/v1/reviews/99999/like"
        );

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testLikeReview()
    {
        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/like"
        );
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $this->review->id,
            'likeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }

    public function testRemoveLikeReview()
    {
        factory(Like::class)->create([
            'user_id' => $this->user->id,
            'likeable_id' => $this->review->id,
            'likeable_type' => Review::class
        ]);

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/like"
        );
        
        $response->assertStatus(200);

        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $this->review->id,
            'likeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }

    public function testLikeAfterDislikeReview()
    {
        factory(Dislike::class)->create([
            'user_id' => $this->user->id,
            'dislikeable_id' => $this->review->id,
            'dislikeable_type' => Review::class
        ]);

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$this->review->id}/like"
        );
        
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $this->review->id,
            'likeable_type' => Review::class,
            'user_id' => $this->user->id
        ])->assertDatabaseMissing('dislikes', [
            'dislikeable_id' => $this->review->id,
            'dislikeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }
}
