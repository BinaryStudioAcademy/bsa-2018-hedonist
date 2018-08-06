<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceTest extends ApiTestCase
{
    public function testGetCollectionEndpoint()
    {
//        $routeName = 'getPlaceCollection';
//        $routeName = 'getPlace';
//        $routeName = 'addPlace';
        $routeName = 'updatePlace';
//        $response = $this->json('GET', route($routeName));
//        $response = $this->json('GET', route($routeName, ['id' => 1]));
//        $response = $this->json('DELETE', route($routeName, ['id' => 3]));
//        $response = $this->json('POST', route($routeName, [
//            'creator_id' => 1,
//            'category_id' => 2,
//            'city_id' => 1,
//            'longitude' => 12.2,
//            'latitude' => 32.3,
//            'zip' => 3322,
//            'address' => 'sdf',
//        ]));
        $response = $this->json('PUT', route($routeName, [
            'id' => 5,
            'creator_id' => 1,
            'category_id' => 2,
            'city_id' => 1,
            'longitude' => 12.2,
            'latitude' => 32.3,
            'zip' => 1122,
            'address' => 'sdf',
        ]));
        dump($response->getContent());

        $this->assertTrue(Route::has($routeName));
        $this->assertEquals('/api/v1/places', route($routeName, [], $absolute = false));
    }

    public function testGetItemEndpoint()
    {
        $routeName = 'places.show';
        $itemIndex = 66;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            '/api/v1/places/'. $itemIndex,
            route($routeName, ['places' => $itemIndex], false)
        );
    }

    public function testAddEndpoint()
    {
        $this->assertTrue(Route::has('places.store'));
    }

    public function testUpdateEndpoint()
    {
        $this->assertTrue(Route::has('places.update'));
    }

    public function testRemoveEndpoint()
    {
        $user = factory(Places::class);
        $this->assertTrue(Route::has('places.destroy'));
    }
}
