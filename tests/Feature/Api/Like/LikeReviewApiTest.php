<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\JwtTestCase;
use Tests\TestCase;

class LikeReviewApiTest extends JwtTestCase
{
    use DatabaseTransactions;
    
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
        $response =  $this->json('POST', "/api/v1/reviews/999/like", []);
        $response->assertStatus(400);
    }

    public function testLikeReview()
    {
        $response =  $this->json('POST', "/api/v1/reviews/{$this->review->id}/like", []);
        $response->assertStatus(201);
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $this->review->id,
            'likeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }
}