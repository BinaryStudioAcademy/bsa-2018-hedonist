<?php


namespace tests\Unit\Routes;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CheckinRoutesTest extends TestCase
{
    public function testIndexEndpoint() : void
    {
        $routeName = 'user.me.checkin';
        $this->assertTrue(Route::has($routeName));
        $this->assertEquals(
            'http://localhost/api/v1/users/me/checkins',
            route($routeName)
        );
    }
}