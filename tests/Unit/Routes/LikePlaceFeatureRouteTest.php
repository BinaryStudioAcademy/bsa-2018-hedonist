<?php

namespace Tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LikePlaceFeatureRouteTest extends TestCase
{
    public function testLikePlaceEndpoint()
    {
        $this->assertTrue(Route::has('place.like'));
    }
}