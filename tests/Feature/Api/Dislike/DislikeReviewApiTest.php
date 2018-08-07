<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\JwtTestCase;
use Tests\TestCase;

class DisikeReviewApiTest extends JwtTestCase
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

    public function testDisikeReviewNotFound()
    {
        $response =  $this->json('POST', "/api/v1/reviews/999/dislike", []);
        $response->assertStatus(400);
    }

    public function testDislikeReview()
    {
        $response =  $this->json('POST', "/api/v1/reviews/{$this->review->id}/dislike", []);
        $response->assertStatus(201);
        $this->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $this->review->id,
            'dislikeable_type' => Review::class,
            'user_id' => $this->user->id
        ]);
    }
}