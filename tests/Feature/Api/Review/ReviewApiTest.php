<?php

namespace Tests\Feature;

use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Entities\User\User;
use Tests\Feature\Api\ApiTestCase;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewApiTest extends ApiTestCase
{
    use RefreshDatabase;

    private $user;
    private $place;
    private $credentials;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->place = factory(Place::class)->create();
        $this->credentials = $this->json('POST', '/api/v1/auth/login', [
            'email'     => $this->user->email,
            'password'  => 'secret'
        ])->getOriginalContent()['data'];
    }

    public function testCreateReview()
    {
        $response = $this->json('POST',
            'api/v1/reviews',
            [
                'user_id'       => $this->user->id,
                'place_id'      => $this->place->id,
                'description'   => 'test test test'
            ],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]
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
            ],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]
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
            ],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]
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
            [],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]);

        $response->assertStatus(200);
    }

    public function testGetReviewNotAuthorize()
    {
        $review = $this->newReview($this->user, $this->place);
        $reviewId = $review->id;

        $response = $this->json('GET', "api/v1/reviews/$reviewId");

        $response->assertStatus(401);
    }

    public function testGetReviewNotFound()
    {
        $response = $this->json('GET',
            'api/v1/reviews/9999999',
            [],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]);

        $response->assertStatus(404);
    }

    public function testGetReviewCollection()
    {
        $response = $this->json('GET',
            'api/v1/reviews',
            [],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]);

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
            ],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]
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
            [],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]
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
            [],
            ['Authorization' => 'Bearer ' . $this->credentials['access_token']]);

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($reviewPhoto->id, $data['data'][0]['id']);
        $this->assertEquals($reviewPhoto->description, $data['data'][0]['description']);
        $this->assertEquals($reviewPhoto->img_url, $data['data'][0]['img_url']);
    }
}
