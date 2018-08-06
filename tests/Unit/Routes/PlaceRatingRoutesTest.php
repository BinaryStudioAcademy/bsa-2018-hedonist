<?php


namespace tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PlaceRatingRoutesTest extends TestCase
{

    public function testSetRate() : void
    {
        $routeName = 'place.rating.setPlaceRating';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals('http://localhost/api/v1/places/rating', route($routeName));
    }

    public function testGetRate() : void
    {
        $routeName = 'place.rating.getPlaceRating';
        $itemIndex = 1;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            'http://localhost/api/v1/places/rating/'. $itemIndex,
            route($routeName, ['id' => $itemIndex])
        );
    }


    public function testGetSingleRateByPlace() : void
    {
        $routeName = 'place.rates.getPlaceRatingByPlaceUser';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            'http://localhost/api/v1/places/rating/byPlaceUser',
            route($routeName)
        );
    }


}