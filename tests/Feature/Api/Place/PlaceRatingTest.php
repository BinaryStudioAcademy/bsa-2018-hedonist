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
    protected $place_1;
    protected $place_2;



    public function setUp()
    {
        parent::setUp();

        DB::table('places_features')->delete();
        $this->authenticatedUser = factory(User::class)->create();
        $this->actingAs($this->authenticatedUser);

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
    }

    public function test_getting_item_by_id() : void
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

    public function test_getting_item_by_place_id_only() : void
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

    public function test_getting_item_by_place_id_and_another_user_id() : void
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
}