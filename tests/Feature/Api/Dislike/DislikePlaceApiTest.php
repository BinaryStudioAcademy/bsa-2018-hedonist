<?php

namespace Tests\Feature\Api\Dislike;

use Tests\Feature\Api\ApiTestCase;

class DislikePlaceApiTest extends ApiTestCase
{
    public function testDislikePlaceNotFound()
    {
        $response = $this->post('/api/v1/places/99999/dislike');
        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }
}