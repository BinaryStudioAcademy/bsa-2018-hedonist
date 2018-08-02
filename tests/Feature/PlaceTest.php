<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    public function testGetCollectionEndpoint()
    {
        $routeName = 'places.index';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals('http://localhost/api/v1/places', route($routeName));
    }

    public function testGetItemEndpoint()
    {
        $routeName = 'places.show';
        $itemIndex = 66;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            'http://localhost/api/v1/places/'. $itemIndex,
            route($routeName, ['places' => $itemIndex])
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
        $this->assertTrue(Route::has('places.destroy'));
        $user = factory(Places::class);
        dump($user);
    }
}
