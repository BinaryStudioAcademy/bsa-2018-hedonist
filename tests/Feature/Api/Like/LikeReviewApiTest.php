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

    protected $user;

    public function setUp()
    {
        parent::setUp();
        
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
        $review = factory(Review::class)->create();
        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$review->id}/like"
        );
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $review->id,
            'likeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }

    public function testRemoveLikeReview()
    {
        $like = factory(Like::class)->create([
            'user_id' => $this->user->id,
            'likeable_id' => factory(Review::class)->create()->id,
            'likeable_type' => Review::class
        ]);

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$like->likeable_id}/like"
        );
        
        $response->assertStatus(200);

        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $like->likeable_id,
            'likeable_type' => $like->likeable_type,
            'user_id' => $this->user->id
        ]);
    }

    public function testLikeAfterDislikeReview()
    {
        $dislike = factory(Dislike::class)->create([
            'user_id' => $this->user->id,
            'dislikeable_id' => factory(Review::class)->create()->id,
            'dislikeable_type' => Review::class
        ]);

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$dislike->dislikeable_id}/like"
        );
        
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $dislike->dislikeable_id,
            'likeable_type' => $dislike->dislikeable_type,
            'user_id' => $this->user->id
        ])->assertDatabaseMissing('dislikes', [
            'dislikeable_id' => $dislike->dislikeable_id,
            'dislikeable_type' => $dislike->dislikeable_type,
            'user_id' => $this->user->id
        ]);
    }

    public function test_get_users_liked_review()
    {
        $review = factory(Review::class)->create();

        $like = factory(Like::class)->create([
            'user_id' => $this->user->id,
            'likeable_id' => $review->id,
            'likeable_type' => Review::class
        ]);

        $response = $this->actingWithToken($this->user)->get(
            "/api/v1/reviews/$review->id/users-liked"
        );
        
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $this->user->id
        ]);
    }
}
