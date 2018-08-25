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
        $this->assertEquals(URL::to('/').'/api/v1/places/rating', route($routeName));
    }

    public function testGetPlaceRatingAvg() : void
    {
        $routeName = 'place.rating.getPlaceRatingAvg';
        $itemIndex = 1;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            URL::to('/')."/api/v1/places/$itemIndex/rating",
            route($routeName, ['id' => $itemIndex])
        );
    }
}