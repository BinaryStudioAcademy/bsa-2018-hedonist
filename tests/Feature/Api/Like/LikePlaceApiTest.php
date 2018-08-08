<?php

namespace Tests\Feature\Api\Like;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class LikePlaceApiTest extends ApiTestCase
{
    use RefreshDatabase;

    public function testLikePlaceNotFound()
    {
        $response = $this->actingWithToken()->post('/api/v1/places/99999/like');

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }
}