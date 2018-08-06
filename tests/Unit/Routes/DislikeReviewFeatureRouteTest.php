<?php

namespace Tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DislikeReviewFeatureRouteTest extends TestCase
{
    public function testDislikeReviewEndpoint()
    {
        $this->assertTrue(Route::has('review.dislike'));
    }
}