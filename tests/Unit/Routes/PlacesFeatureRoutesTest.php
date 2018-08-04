<?php


namespace tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PlacesFeatureRoutesTest extends TestCase
{

    public function testIndexEndpoint() : void
    {
        $routeName = 'special-features.index';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals('http://localhost/api/v1/places/special-features', route($routeName));
    }

    public function testCreateEndpoint() : void
    {
        $this->assertTrue(Route::has('special-features.store'));
    }

    public function testReadEndpoint() : void
    {
        $routeName = 'special-features.show';
        $itemIndex = 1;
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            'http://localhost/api/v1/places/special-features/'. $itemIndex,
            route($routeName, ['special_feature' => $itemIndex])
        );
    }

    public function testNoUpdateEndpoint() : void
    {
        $this->assertFalse(Route::has('special-features.edit'));
        $this->assertFalse(Route::has('special-features.update'));

    }

    public function testDeleteEndpoint() : void
    {
        $this->assertTrue(Route::has('special-features.destroy'));

    }


}