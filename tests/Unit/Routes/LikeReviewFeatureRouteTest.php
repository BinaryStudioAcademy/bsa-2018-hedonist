<?php

namespace Tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LikeReviwFeatureRouteTest extends TestCase
{
    public function testLikeReviewEndpoint()
    {
        $this->assertTrue(Route::has('review.like'));
    }
}