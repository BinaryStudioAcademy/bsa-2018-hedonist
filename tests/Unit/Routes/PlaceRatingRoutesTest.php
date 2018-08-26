<?php

namespace tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class PlaceRatingRoutesTest extends TestCase
{
    public function testSetRate() : void
    {
        $routeName = 'place.rating.setPlaceRating';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(URL::to('/').'/api/v1/places/1/ratings', route($routeName, 1));
    }

    public function testGetPlaceRatingAvg() : void
    {
        $routeName = 'place.rating.getPlaceRatingAvg';
        $itemIndex = 1;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            URL::to('/')."/api/v1/places/$itemIndex/ratings/avg",
            route($routeName, ['id' => $itemIndex])
        );
    }
}