<?php

namespace Tests\Feature\Api\Like;

use Tests\Feature\Api\ApiTestCase;

class LikePlaceApiTest extends ApiTestCase
{
    public function testLikePlaceNotFound()
    {
        $response = $this->post('/api/v1/places/99999/like');
        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }
}