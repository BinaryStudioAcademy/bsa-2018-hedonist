<?php

namespace Tests\Feature\Api;

use Hedonist\Entities\Place\Place;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceTest extends ApiTestCase
{
    use DatabaseTransactions;

    private $place;
    private $credentials;
    const ENDPOINT = '/api/v1/places';

    public function setUp()
    {
        parent::setUp();

        $this->place = factory(Place::class)->create();
        $this->credentials = auth()->login($this->place->creator);
    }

    public function testGetCollection()
    {
        $routeName = 'getPlaceCollection';
        $response =  $this->json(
            'GET',
            self::ENDPOINT,
            [],
            ['HTTP_Authorization' => 'Bearer ' . $this->credentials]
        );
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

    public function testGetPlace()
    {
        $routeName = 'getPlace';
        $response =  $this->json(
            'GET',
            self::ENDPOINT . "/{$this->place->id}",
            [],
            ['HTTP_Authorization' => 'Bearer ' . $this->credentials]
        );

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->checkJsonStructure($response);
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            self::ENDPOINT . "/{$this->place->id}",
            route($routeName, ['id' => $this->place->id], false)
        );
    }

    public function testAddPlace()
    {
        $routeName = 'addPlace';
        $response = $this->json(
            'POST', route($routeName),
            [
                'creator_id' => $this->place->creator->id,
                'category_id' => $this->place->category->id,
                'city_id' => $this->place->city->id,
                'longitude' => -20,
                'latitude' => 32.3,
                'zip' => 3322,
                'address' => 'sdf',
            ],
            [
                'HTTP_Authorization' => 'Bearer ' . $this->credentials
            ]
        );
        $newPlace = $response->getOriginalContent();

        $this->assertDatabaseHas('places', [
            'id' => $newPlace['data']['id'],
        ]);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');
        $this->checkJsonStructure($response);
        $this->assertTrue(Route::has('addPlace'));
    }

    public function testUpdatePlace()
    {
        $routeName = 'updatePlace';
        $response = $this->json(
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
            ],
            [
                'HTTP_Authorization' => 'Bearer ' . $this->credentials
            ]
        );
        $updatedPlace = $response->getOriginalContent();

        $this->assertEquals(33.3, $updatedPlace['data']['latitude']);
        $this->assertEquals(1234, $updatedPlace['data']['zip']);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');
        $this->checkJsonStructure($response);
        $this->assertTrue(Route::has('updatePlace'));
    }

    public function testRemovePlace()
    {
        $response = $this->json(
            'DELETE',
            self::ENDPOINT . "/{$this->place->id}",
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $this->credentials
            ]
        );

        $this->assertDatabaseMissing('places', [
            'id' => $this->place->id,
            'deleted_at' => null
        ]);
        $response->assertStatus(204);
        $response->assertHeaderMissing('Content-Type');
        $this->assertTrue(Route::has('removePlace'));
    }

    public function testShowNotExistingPlace()
    {
        $response =  $this->json(
            'GET',
            self::ENDPOINT . '/99999999',
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $this->credentials
            ]
        );
        $response->assertStatus(404);
    }

    public function testDestroyNotExistingId()
    {
        $response =  $this->json(
            'DELETE',
            self::ENDPOINT . '/99999999',
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $this->credentials
            ]
        );
        $response->assertStatus(404);
    }

    public function testWrongDataUpdate()
    {
        $routeName = 'updatePlace';
        $response = $this->json(
            'PUT',
            route($routeName, ['id' => $this->place->id]),
            [
                'creator_id' => -1,
                'category_id' => -1,
                'city_id' => -1,
                'longitude' => -9999,
                'latitude' => 99999999,
                'zip' => 1234,
                'address' => 'sdf',
            ],
            [
                'HTTP_Authorization' => 'Bearer ' . $this->credentials
            ]
        );

        $response->assertStatus(400);
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
