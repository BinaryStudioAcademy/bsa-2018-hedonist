<?php

namespace Tests\Feature\Api;

use Hedonist\Entities\Place\Place;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceTest extends ApiTestCase
{
    use DatabaseTransactions;

    private $placeId;
    private $cityId;
    private $creatorId;
    private $categoryId;
    const ENDPOINT = '/api/v1/places';

    public function setUp()
    {
        parent::setUp();

        $place = factory(Place::class)->create();
        $this->placeId = $place->id;
        $this->cityId = $place->city_id;
        $this->creatorId = $place->creator_id;
        $this->categoryId = $place->category_id;
    }

    public function testGetCollection()
    {
        $routeName = 'getPlaceCollection';
        $response =  $this->json('GET', self::ENDPOINT);
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $arrayContent = $response->getOriginalContent();

        $this->assertTrue(isset(
            $arrayContent['data'][0]['id'],
            $arrayContent['data'][0]['city'],
            $arrayContent['data'][0]['creator'])
        );
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(self::ENDPOINT, route($routeName, [], $absolute = false));
    }

    public function testGetItem()
    {
        $routeName = 'getPlace';
        $response =  $this->json('GET', self::ENDPOINT . "/{$this->placeId}");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->checkJsonStructure($response);
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            self::ENDPOINT . "/{$this->placeId}",
            route($routeName, ['id' => $this->placeId], false)
        );
    }

    public function testAddEndpoint()
    {
        $routeName = 'addPlace';
        $response = $this->json('POST', route($routeName), [
            'creator_id' => $this->categoryId,
            'category_id' => $this->creatorId,
            'city_id' => $this->cityId,
            'longitude' => -20,
            'latitude' => 32.3,
            'zip' => 3322,
            'address' => 'sdf',
        ]);
        $newPlace = $response->getOriginalContent();

        $this->assertDatabaseHas('places', [
            'id' => $newPlace['data']['id'],
        ]);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');
        $this->checkJsonStructure($response);
        $this->assertTrue(Route::has('addPlace'));
    }

    public function testUpdateEndpoint()
    {
        $routeName = 'updatePlace';
        $response = $this->json('PUT', route($routeName, ['id' => $this->placeId]), [
            'creator_id' => $this->categoryId,
            'category_id' => $this->creatorId,
            'city_id' => $this->cityId,
            'longitude' => -90,
            'latitude' => 33.3,
            'zip' => 1234,
            'address' => 'sdf',
        ]);
        $updatedPlace = $response->getOriginalContent();
//        dump($updatedPlace);
//
//        $this->assertEquals(33.3, $updatedPlace['data']['latitude']);
//        $this->assertEquals(1234, $updatedPlace['data']['zip']);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');
        $this->checkJsonStructure($response);
        $this->assertTrue(Route::has('updatePlace'));
    }

    public function testRemoveEndpoint()
    {
        $response = $this->json('DELETE', self::ENDPOINT . "/{$this->placeId}");

        $this->assertDatabaseMissing('places', [
            'id' => $this->placeId,
            'deleted_at' => null
        ]);
        $response->assertStatus(204);
        $response->assertHeaderMissing('Content-Type');
        $this->assertTrue(Route::has('removePlace'));
    }

    public function testShowNotExistingPlace()
    {
        $response =  $this->json('GET', self::ENDPOINT . '/99999999');
        $response->assertStatus(404);
    }

    public function testDestroyNotExistingId()
    {
        $response =  $this->json('DELETE', self::ENDPOINT . '/99999999');
        $response->assertStatus(404);
    }

    public function testWrongDataUpdate()
    {
        $routeName = 'updatePlace';
        $response = $this->json('PUT', route($routeName, ['id' => $this->placeId]), [
            'creator_id' => -1,
            'category_id' => -1,
            'city_id' => -1,
            'longitude' => -9999,
            'latitude' => 99999999,
            'zip' => 1234,
            'address' => 'sdf',
        ]);

//        $response->assertStatus(400); // TODO needs to be 400 status
        $response->assertStatus(422);
    }

    public function checkJsonStructure($response)
    {
        /* @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response->assertJsonStructure(['data' => [
            'id',
            'creator',
            'category',
            'city',
            'longitude',
            'latitude',
            'zip',
            'address'
        ]]);
    }
}
