<?php

namespace Tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DislikePlaceFeatureRouteTest extends TestCase
{
    public function testDislikePlaceEndpoint()
    {
        $this->assertTrue(Route::has('place.dislike'));
    }
}