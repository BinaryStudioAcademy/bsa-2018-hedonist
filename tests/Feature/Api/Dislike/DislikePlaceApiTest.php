<?php

namespace Tests\Feature\Api\Dislike;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class DislikePlaceApiTest extends ApiTestCase
{
    use RefreshDatabase;

    public function testDislikePlaceNotFound()
    {
        $response = $this->actingWithToken()->post('/api/v1/places/99999/dislike');

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }
}