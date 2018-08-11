<?php

namespace tests\Feature\Api\Place;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceRating;
use Hedonist\Entities\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Api\ApiTestCase;
use Tests\JwtTestCase;

class PlaceRatingTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $authenticatedUser;
    protected $anotherUser;
    protected $place_1_rating_1;
    protected $place_1_rating_2;
    protected $place_1_rating_3;
    protected $place_1;
    protected $place_2;


    public function setUp()
    {
        parent::setUp();

        DB::table('places_features')->delete();
        $this->authenticatedUser = factory(User::class)->create();
        $this->actingWithToken($this->authenticatedUser);

        $this->place_1 = factory(Place::class)->create();
        $this->place_1_rating_1 = factory(PlaceRating::class)->create([
            'user_id' => $this->authenticatedUser->id,
            'place_id' => $this->place_1->id,
        ]);
        $this->anotherUser = factory(User::class)->create();
        $this->place_1_rating_2 = factory(PlaceRating::class)->create([
            'user_id' => $this->anotherUser->id,
            'place_id' => $this->place_1->id,
        ]);
        $this->place_1_rating_3 = factory(PlaceRating::class)->create([
            'place_id' => $this->place_1->id,
        ]);

        $this->place_2 = factory(Place::class)->create();
    }

    public function test_get_rating_by_id(): void
    {
        $id = $this->place_1_rating_1->id;
        $rating = $this->place_1_rating_1->rating;

        $response = $this->json('GET', "api/v1/places/rating/$id", [
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'id' => $id,
            'rating' => $rating
        ]);

        $response = $this->json('GET', 'api/v1/places/rating/999', [
        ]);
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'httpStatus' => 400,
            'message' => 'Item not found',
        ]);
    }

    public function test_get_rating_by_place_id_only(): void
    {
        $id = $this->place_1_rating_1->id;
        $placeId = $this->place_1_rating_1->place_id;
        $rating = $this->place_1_rating_1->rating;

        $response = $this->json('GET', 'api/v1/places/rating/byPlaceUser', [
            'place_id' => $placeId
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'id' => $id,
            'place_id' => $placeId,
            'rating' => $rating
        ]);

        $response = $this->json('GET', 'api/v1/places/rating/byPlaceUser', [
            'place_id' => 9999
        ]);

        $response->assertStatus(400);
        $response->assertJsonFragment([
            'httpStatus' => 400,
            'message' => 'Item not found',
        ]);
    }

    public function test_get_rating_by_place_id_and_another_user_id(): void
    {
        $id = $this->place_1_rating_2->id;
        $anotherUserId = $this->place_1_rating_2->user_id;
        $placeId = $this->place_1_rating_2->place_id;
        $rating = $this->place_1_rating_2->rating;

        $response = $this->json('GET', 'api/v1/places/rating/byPlaceUser', [
            'place_id' => $placeId,
            'user_id' => $anotherUserId
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'id' => $id,
            'user_id' => $anotherUserId,
            'place_id' => $placeId,
            'rating' => $rating
        ]);

        $response = $this->json('GET', 'api/v1/places/rating/byPlaceUser', [
            'place_id' => 9999
        ]);

        $response->assertStatus(400);
        $response->assertJsonFragment([
            'httpStatus' => 400,
            'message' => 'Item not found',
        ]);
    }

    public function test_gett_average_rating_by_place_id(): void
    {
        $placeId = $this->place_1_rating_1->place_id;
        $ratings = [
            $this->place_1_rating_1->rating,
            $this->place_1_rating_2->rating,
            $this->place_1_rating_3->rating,
        ];
        $ratingAvg = round(array_sum($ratings) / \count($ratings), 1);

        $response = $this->json('GET', "api/v1/places/rating/place/$placeId", [
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'place_id' => $placeId,
            'rating' => $ratingAvg
        ]);

        $response = $this->json('GET', 'api/v1/places/rating/place/999', [
        ]);

        $response->assertStatus(400);
        $response->assertJsonFragment([
            'httpStatus' => 400,
            'message' => 'Item not found',
        ]);
    }

    public function test_set_rating_by_place_id(): void
    {
        $placeId = $this->place_2->id;
        $rating = random_int(0, 10);

        $this->assertDatabaseMissing('place_rating', [
            'user_id' => $this->authenticatedUser->id,
            'place_id' => $placeId
        ]);

        $response = $this->json('POST', 'api/v1/places/rating', [
            'place_id' => $placeId,
            'rating' => $rating
        ]);
        $ratingId = $response->getOriginalContent()['data']['id'];

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'user_id' => $this->authenticatedUser->id,
            'place_id' => $placeId,
            'rating' => $rating
        ]);

        $this->assertDatabaseHas('place_rating', [
            'id' => $ratingId,
            'user_id' => $this->authenticatedUser->id,
            'place_id' => $placeId,
            'rating' => $rating
        ]);

        $ratingNew = random_int(0, 10);

        $response = $this->json('POST', 'api/v1/places/rating', [
            'place_id' => $placeId,
            'rating' => $ratingNew
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'id' => $ratingId,
            'user_id' => $this->authenticatedUser->id,
            'place_id' => $placeId,
            'rating' => $ratingNew
        ]);

        $this->assertDatabaseHas('place_rating', [
            'id' => $ratingId,
            'user_id' => $this->authenticatedUser->id,
            'place_id' => $placeId,
            'rating' => $ratingNew
        ]);
    }

    public function test_set_rating_validation(): void
    {
        $placeId = $this->place_1_rating_1->place_id;
        $rating_less = random_int(-100, -1);
        $rating_over = random_int(11, 100);

        $response = $this->json('POST', 'api/v1/places/rating', [
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'errors' => [
                'place_id' => ['The place id field is required.'],
                'rating' => ['The rating field is required.']
            ],
            'message' => 'The given data was invalid.'
        ]);

        $response = $this->json('POST', 'api/v1/places/rating', [
            'place_id' => 'k',
            'rating' => $rating_less
        ]);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid.',
            'errors' => [
                'place_id' => [
                    0 => 'The place id must be an integer.'
                ],
            ]
        ]);

        $response = $this->json('POST', 'api/v1/places/rating', [
            'place_id' => $placeId,
            'rating' => $rating_over
        ]);
        $response->assertJsonFragment([
            'error' => [
                'httpStatus' => 400,
                'message' => 'Rating value must be between 0 and 10'
            ]
        ]);

        $response = $this->json('POST', 'api/v1/places/rating', [
            'place_id' => $placeId,
            'rating' => $rating_less
        ]);
        $response->assertJsonFragment([
            'error' => [
                'httpStatus' => 400,
                'message' => 'Rating value must be between 0 and 10'
            ]
        ]);
    }
}