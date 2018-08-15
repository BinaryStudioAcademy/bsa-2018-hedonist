<?php

namespace Tests\Feature\Api\Place;

use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class PlaceCategoryControllerTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingWithToken($this->user);
    }

    public function test_add_place_category()
    {
        $data = [
            'name' => 'Bar',
        ];
        $response = $this->json('POST', '/api/v1/places/categories', $data);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('place_categories', $data);
    }

    public function test_get_place_category()
    {
        $placeCategory = factory(PlaceCategory::class)->create();
        $response = $this->json('GET', "/api/v1/places/categories/$placeCategory->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($placeCategory->id, $data['data']['id']);
        $this->assertEquals($placeCategory->name, $data['data']['name']);
    }

    public function test_update_place_category()
    {
        $placeCategory = factory(PlaceCategory::class)->create();
        $data = [
            'name' => 'Caffe',
        ];
        $response = $this->json('PUT', "/api/v1/places/categories/$placeCategory->id", $data);
        $result = json_decode($response->getContent(), true);
        $this->assertEquals($result['data']['name'], $data['name']);
    }

    public function test_delete_place_category()
    {
        $placeCategory = factory(PlaceCategory::class)->create();
        $this->json('DELETE', "/api/v1/places/categories/$placeCategory->id");

        $this->json('GET', "/api/v1/places/categories/$placeCategory->id")->assertStatus(404);
    }

    public function test_get_all_place_category()
    {
        $placeCategories = [];
        for ($i = 0; $i < 3; $i++) {
            $placeCategories[] = factory(PlaceCategory::class)->create();
        }

        $response = $this->json('GET', "/api/v1/places/categories");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(count($data['data']), count($placeCategories));
    }

    public function test_get_place_category_not_found()
    {
        $this->json('GET', "/api/v1/places/categories/1")->assertStatus(404);
    }
}