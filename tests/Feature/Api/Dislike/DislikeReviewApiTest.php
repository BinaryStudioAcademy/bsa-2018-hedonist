<?php

namespace Tests\Feature\Api\Dislike;

use Hedonist\Entities\User\User;
use Tests\Feature\Api\ApiTestCase;

class DislikePlaceApiTest extends ApiTestCase
{
    public function testDislikePlaceNotFound()
    {
        $user = factory(User::class)->create();
        $token = \JWTAuth::fromUser($user);

        $response = $this->post('/api/v1/reviews/99999/dislike', [], ['Authorization' => 'Bearer ' . $token]);
        
        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }
}