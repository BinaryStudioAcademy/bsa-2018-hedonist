<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\{ User, UserInfo };
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Like\Like;
use Hedonist\Entities\Dislike\Dislike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class DislikeReviewApiTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        factory(UserInfo::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    public function testDislikeReviewNotFound()
    {
        $response = $this->actingWithToken()->post(
            "/api/v1/reviews/99999/dislike"
        );

        $response->assertHeader('Content-Type', 'application/json')
            ->assertStatus(400)
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testDislikeReview()
    {
        $review = factory(Review::class)->create();
        factory(UserInfo::class)->create([
            'user_id' => $review->user_id,
        ]);
        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$review->id}/dislike"
        );

        $response->assertStatus(200);
        $this->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $review->id,
            'dislikeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }

    public function testRemoveDislikeReview()
    {
        $dislike = factory(Dislike::class)->create([
            'user_id' => $this->user->id,
            'dislikeable_id' => factory(Review::class)->create()->id,
            'dislikeable_type' => Review::class
        ]);

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$dislike->dislikeable_id}/dislike"
        );
        
        $response->assertStatus(200);

        $this->assertDatabaseMissing('dislikes', [
            'dislikeable_id' => $dislike->dislikeable_id,
            'dislikeable_type' => $dislike->dislikeable_type,
            'user_id' => $this->user->id
        ]);
    }

    public function testDislikeAfterLikeReview()
    {
        $review = factory(Review::class)->create();
        $like = factory(Like::class)->create([
            'user_id' => $this->user->id,
            'likeable_id' => $review->id,
            'likeable_type' => Review::class
        ]);
        factory(UserInfo::class)->create([
            'user_id' => $review->user_id,
        ]);

        $response = $this->actingWithToken($this->user)->post(
            "/api/v1/reviews/{$like->likeable_id}/dislike"
        );
        
        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $like->likeable_id,
            'likeable_type' => $like->likeable_type,
            'user_id' => $this->user->id
        ])->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $like->likeable_id,
            'dislikeable_type' => $like->likeable_type,
            'user_id' => $this->user->id
        ]);
    }

    public function test_get_users_disliked_review()
    {
        factory(UserInfo::class)->create(['user_id' => $this->user->id]);
        $review = factory(Review::class)->create();

        $user2 = factory(User::class)->create();
        factory(UserInfo::class)->create(['user_id' => $user2->id]);

        factory(Dislike::class)->create([
            'user_id' => $this->user->id,
            'dislikeable_id' => $review->id,
            'dislikeable_type' => Review::class
        ]);
        factory(Dislike::class)->create([
            'user_id' => $user2->id,
            'dislikeable_id' => $review->id,
            'dislikeable_type' => Review::class
        ]);

        $response = $this->actingWithToken($this->user)->get(
            "/api/v1/reviews/$review->id/users-disliked"
        );
        
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $this->user->id
        ])->assertJsonFragment([
            'id' => $user2->id
        ]);
    }
}
