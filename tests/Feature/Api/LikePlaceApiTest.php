<?php

namespace Tests\Feature\Api;

class LikePlaceApiTest extends ApiTestCase
{
    public function testLikePlaceNotFound()
    {
        $response = $this->post('/api/v1/places/99999/like');
        $response->assertNotFound();
    }
}