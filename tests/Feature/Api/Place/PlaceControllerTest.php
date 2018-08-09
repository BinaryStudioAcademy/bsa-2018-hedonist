<?php

namespace tests\Feature\Api\Place;


use Hedonist\Entities\Place\Place;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Tests\Feature\Api\ApiTestCase;

class PlaceControllerTest extends ApiTestCase
{
    use DatabaseTransactions;

    private $place;
    const ENDPOINT = '/api/v1/places';

    public function setUp()
    {
        parent::setUp();

        $this->place = factory(Place::class)->create();
    }

    public function testGetCollection()
    {
        $routeName = 'getPlaceCollection';
        $response =  $this->actingWithToken()->json(
            'GET',
            self::ENDPOINT
        );
        $arrayContent = $response->getOriginalContent();

        $this->assertTrue(isset(
            $arrayContent['data'][0]['id'],
            $arrayContent['data'][0]['city'],
            $arrayContent['data'][0]['creator'])
        );
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testGetPlace()
    {
        $routeName = 'getPlace';
        $response =  $this->actingWithToken()->json(
            'GET',
            self::ENDPOINT . "/{$this->place->id}"
        );

        $this->checkJsonStructure($response);
        $this->assertEquals(
            self::ENDPOINT . "/{$this->place->id}",
            route($routeName, ['id' => $this->place->id], false)
        );
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testAddPlace()
    {
        $routeName = 'addPlace';
        $response = $this->actingWithToken()->json(
            'POST', route($routeName),
            [
                'creator_id' => $this->place->creator->id,
                'category_id' => $this->place->category->id,
                'city_id' => $this->place->city->id,
                'longitude' => -20,
                'latitude' => 32.3,
                'zip' => 3322,
                'address' => 'sdf',
                'phone' => +380636678400,
                'website' => 'http://whymytestsarebrokenwhilemybranchalreadymerged3daysago.wtf',
            ]
        );
        $newPlace = $response->getOriginalContent();

        $this->assertDatabaseHas('places', [
            'id' => $newPlace['data']['id'],
        ]);
        $this->checkJsonStructure($response);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testUpdatePlace()
    {
        $routeName = 'updatePlace';
        $response = $this->actingWithToken()->json(
            'PUT',
            route($routeName, ['id' => $this->place->id]),
            [
                'creator_id' => $this->place->creator->id,
                'category_id' => $this->place->category->id,
                'city_id' => $this->place->city->id,
                'longitude' => -90,
                'latitude' => 33.3,
                'zip' => 1234,
                'address' => 'sdf',
                'phone' => +380636678400,
                'website' => 'http://whymytestsarebrokenwhilemybranchalreadymerged3daysago.wtf',
            ]
        );
        $updatedPlace = $response->getOriginalContent();

        $this->assertEquals(33.3, $updatedPlace['data']['latitude']);
        $this->assertEquals(1234, $updatedPlace['data']['zip']);
        $this->checkJsonStructure($response);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testRemovePlace()
    {
        $response = $this->actingWithToken()->json(
            'DELETE',
            self::ENDPOINT . "/{$this->place->id}"
        );

        $this->assertDatabaseMissing('places', [
            'id' => $this->place->id,
            'deleted_at' => null
        ]);
        $response->assertStatus(204);
        $response->assertHeaderMissing('Content-Type');
    }

    public function testShowNotExistingPlace()
    {
        $response =  $this->actingWithToken()->json(
            'GET',
            self::ENDPOINT . '/99999999'
        );
        $response->assertStatus(404);
    }

    public function testDestroyNotExistingId()
    {
        $response =  $this->actingWithToken()->json(
            'DELETE',
            self::ENDPOINT . '/99999999'
        );
        $response->assertStatus(404);
    }

    public function testWrongDataUpdate()
    {
        $routeName = 'updatePlace';
        $response = $this->actingWithToken()->json(
            'PUT',
            route($routeName, ['id' => $this->place->id]),
            [
                'creator_id' => -1,
                'category_id' => 'ew',
                'city_id' => 'df',
                'longitude' => -9999,
                'latitude' => 99999999,
                'zip' => 1234,
                'address' => 'sdf',
                'phone' => 'dsd',
                'website' => 'ghf',
            ]
        );

        $response->assertStatus(422);
    }

    public function testGetPlaceCollectionUnauthenticated()
    {
        $response = $this->call('GET', self::ENDPOINT);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->status());
    }

    public function checkJsonStructure($response)
    {
        /* @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response->assertJsonStructure(['data' => [
            'id',
            'creator_id',
            'category_id',
            'city_id',
            'longitude',
            'latitude',
            'zip',
            'address',
            'phone',
            'website'
        ]]);
    }
}
