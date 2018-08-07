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
        $response =  $this->json('POST', "/api/v1/reviews/999/dislike", []);
        $response->assertStatus(404);
    }

    public function testLikeReview()
    {
        $response =  $this->json('POST', "/api/v1/reviews/{$this->review->id}/dislike", []);
        $response->assertStatus(200);
    }
}