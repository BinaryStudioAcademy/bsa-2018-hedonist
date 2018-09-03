<?php

namespace Tests\Feature;

use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Tests\Feature\Api\ApiTestCase;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewApiTest extends ApiTestCase
{
    use RefreshDatabase;

    private $user;
    private $place;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(UserInfo::class)->create([
            'user_id' => $this->user->id,
        ]);
        $this->place = factory(Place::class)->create();
        $this->actingWithToken($this->user);
    }

    public function testCreateReview()
    {
        $response = $this->json('POST',
            'api/v1/reviews',
            [
                'user_id'       => $this->user->id,
                'place_id'      => $this->place->id,
                'description'   => 'test test test'
            ]
        );
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('reviews',
            [
                'user_id'   => $this->user->id,
                'place_id'  => $this->place->id
            ]
        );
    }

    public function testCreateReviewNoUser()
    {
        $response = $this->json('POST',
            'api/v1/reviews',
            [
                'user_id'       => 99999999,
                'place_id'      => $this->place->id,
                'description'   => 'test test test'
            ]
        );

        $response->assertStatus(400);
        $response->assertExactJson(
            [
                'error' => [
                    'message'       => 'User NOT found!',
                    'httpStatus'    => 400
                ]
            ]
        );
    }

    public function testCreateReviewNoPlace()
    {
        $response = $this->json('POST',
            'api/v1/reviews',
            [
                'user_id'       => $this->user->id,
                'place_id'      => 99999999,
                'description'   => 'test test test'
            ]
        );

        $response->assertStatus(400);
        $response->assertExactJson(
            [
                'error' => [
                    'message'       => 'Place does NOT exist!',
                    'httpStatus'    => 400
                ]
            ]
        );
    }

    public function testGetReview()
    {
        $review = $this->newReview($this->user, $this->place);
        $reviewId = $review->id;

        $response = $this->json('GET',
            "api/v1/reviews/$reviewId",
            []);

        $response->assertStatus(200);
    }

    public function testGetReviewNotFound()
    {
        $response = $this->json('GET',
            'api/v1/reviews/9999999',
            []);

        $response->assertStatus(404);
    }

    public function testGetReviewCollection()
    {
        $response = $this->json('GET',
            'api/v1/reviews',
            []);

        $response->assertStatus(200);
    }

    public function testUpdateReview()
    {
        $review = $this->newReview($this->user, $this->place);
        $reviewId = $review->id;

        $this->assertDatabaseHas('reviews',
            [
                'id'        => $reviewId,
                'user_id'   => $this->user->id,
                'place_id'  => $this->place->id
            ]
        );

        $response = $this->json('PUT',
            "api/v1/reviews/$reviewId",
            [
                'user_id'       => $this->user->id,
                'place_id'      => $review->place_id,
                'description'   => 'test-update-description!'
            ]
        );

        $response->assertStatus(200);

        $this->assertDatabaseMissing('reviews',
            [
                'id'            => $reviewId,
                'user_id'       => $this->user->id,
                'place_id'      => $this->place->id,
                'description'   => 'Lorem ipsum dolor sit amet..'
            ]
        );

        $this->assertDatabaseHas('reviews',
            [
                'id'        => $reviewId,
                'user_id'   => $this->user->id,
                'place_id'  => $this->place->id,
                'description'   => 'test-update-description!'
            ]
        );
    }

    public function testDeleteReview()
    {
        $review = $this->newReview($this->user, $this->place);
        $reviewId = $review->id;

        $this->assertDatabaseHas('reviews',
            [
                'id'        => $reviewId,
                'user_id'   => $this->user->id,
                'place_id'  => $this->place->id
            ]
        );

        $response = $this->json('DELETE',
            "api/v1/reviews/$review->id",
            []
        );

        $response->assertStatus(200);
        $this->assertDatabaseMissing('reviews',
            [
                'id'        => $reviewId,
                'user_id'   => $this->user->id,
                'place_id'  => $this->place->id
            ]
        );
    }

    private function newReview(User $user, Place $place)
    {
        return Review::create(
            [
                'user_id'       => $user->getAttribute('id'),
                'place_id'      => $place->getAttribute('id'),
                'description'   => 'Lorem ipsum dolor sit amet..'
            ]
        );
    }

    public function test_get_photos_by_review()
    {
        $reviewPhoto = factory(ReviewPhoto::class)->create();
        $response = $this->json('GET',
            "/api/v1/reviews/$reviewPhoto->review_id/photos",
            []);

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($reviewPhoto->id, $data['data'][0]['id']);
        $this->assertEquals($reviewPhoto->description, $data['data'][0]['description']);
        $this->assertEquals($reviewPhoto->img_url, $data['data'][0]['img_url']);
    }
}
