<?php


namespace tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PlacesFeatureRoutesTest extends TestCase
{

    public function testIndexEndpoint() : void
    {
        $routeName = 'place.features.indexFeature';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            'http://localhost/api/v1/places/features',
            route($routeName)
        );
    }

    public function testStoreEndpoint() : void
    {
        $this->assertTrue(Route::has('place.features.storeFeature'));
    }

    public function testShowEndpoint() : void
    {
        $routeName = 'place.features.showFeature';
        $itemIndex = 1;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            'http://localhost/api/v1/places/features/'. $itemIndex,
            route($routeName, ['special_feature' => $itemIndex])
        );
    }

    public function testNoUpdateEndpoint() : void
    {
        $this->assertFalse(Route::has('place.features.edit'));
        $this->assertFalse(Route::has('place.features.update'));
    }

    public function testDeleteEndpoint() : void
    {
        $this->assertTrue(Route::has('place.features.deleteFeature'));
    }


}