<?php

namespace tests\Feature\Api\Place;

use Hedonist\Entities\Place\PlaceFeature;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\JwtTestCase;
use Tests\TestCase;
use Hedonist\Entities\User\User;

class PlaceFeaturesControllerTest extends JwtTestCase
{
    use DatabaseTransactions;

    protected $user;
    /** @var PlaceFeature */
    protected $placeFeature_1;
    /** @var PlaceFeature */
    protected $placeFeature_2;

    public function setUp()
    {
        parent::setUp();

        DB::table('places_features')->delete();

        $this->actingAsJwtToken();

        /** @var PlaceFeature placeFeature_1 */
        $this->placeFeature_1 = factory(\Hedonist\Entities\Place\PlaceFeature::class, 1)->create([
            'name' => 'wi-fi'
        ])->first();
        $this->placeFeature_2 = factory(\Hedonist\Entities\Place\PlaceFeature::class, 1)->create([
            'name' => 'music'
        ])->first();
    }

    public function test_getting_item_by_id() : void
    {
        $id = $this->placeFeature_1->id;
        $name = $this->placeFeature_1->name;

        $response = $this->json('GET', "/api/v1/auth/places/features/$id", [
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'id' => $id,
            'name' => $name
        ]);

        $response = $this->json('GET', '/api/v1/auth/places/features/999', [
        ]);
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'httpStatus' => 400,
            'message' => "Trying to get property 'id' of non-object",
        ]);

    }

    public function test_gettind_items_collection() : void
    {
        $id_1 = $this->placeFeature_1->id;
        $name_1 = $this->placeFeature_1->name;
        $id_2 = $this->placeFeature_2->id;
        $name_2 = $this->placeFeature_2->name;

        $response = $this->json('GET', '/api/v1/auth/places/features/', [
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'data' => [
            $id_1 => [
                'id' => $id_1,
                'name' => $name_1
                ],
            $id_2 => [
                'id' => $id_2,
                'name' => $name_2
                ]
            ]
        ]);
    }

    public function test_create_item() : void
    {
        $response = $this->json('POST', '/api/v1/auth/places/features/', [
            'name' => 'hukabuka'
        ]);

        $id = $response->getOriginalContent()['data']['id'];

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'data' => [
                    'id' => $id,
                    'name' => 'hukabuka'
            ]
        ]);
        $this->assertDatabaseHas('places_features', [
            'id' => $id,
            'name' => 'hukabuka'
        ]);

        $response = $this->json('POST', '/api/v1/auth/places/features/', [
            'name' => 'hukabuka'
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => ['The name has already been taken.']
            ]
        ]);

        $response = $this->json('POST', '/api/v1/auth/places/features/', [
            'name' => 'hukabuka-hukabuka-hukabuka-hukabuka-hukabuka-hukabuka-hukabuka'
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => ['The name may not be greater than 45 characters.']
            ]
        ]);
        $this->assertDatabaseMissing('places_features', [
            'name' => 'hukabuka-hukabuka-hukabuka-hukabuka-hukabuka-hukabuka-hukabuka'
        ]);
    }

    public function test_delete_item() : void
    {
        $id = $this->placeFeature_1->id;
        $name = $this->placeFeature_1->name;

        $this->assertDatabaseHas('places_features', [
            'id' => $id,
            'name' => $name
        ]);
        $response = $this->json('DELETE', "/api/v1/auth/places/features/$id", [
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'data' => [
                'id' => $id,
                'response' => 'deleted'
            ]
        ]);
        $this->assertDatabaseMissing('places_features', [
            'id' => $id,
            'name' => $name,
            'deleted_at' => null
        ]);

        $response = $this->json('DELETE', "/api/v1/auth/places/features/$id", [
        ]);
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'error' => [
                'httpStatus' => 400,
                'message' => "Item #$id not found"
            ]
        ]);
    }
}