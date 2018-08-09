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
            URL::to('/').'/api/v1/places/rating/place/'. $itemIndex,
            route($routeName, ['id' => $itemIndex])
        );
    }

    public function testGetRate() : void
    {
        $routeName = 'place.rating.getPlaceRating';
        $itemIndex = 1;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            URL::to('/').'/api/v1/places/rating/'. $itemIndex,
            route($routeName, ['id' => $itemIndex])
        );
    }

    public function testGetSingleRateByPlace() : void
    {
        $routeName = 'place.rating.getPlaceRatingByPlaceUser';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            URL::to('/').'/api/v1/places/rating/byPlaceUser',
            route($routeName)
        );
    }
}