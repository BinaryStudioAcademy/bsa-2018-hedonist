<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class LikePlaceApiTest extends ApiTestCase
{
    use RefreshDatabase;

    private function login(User $user): array
    {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        return $response->json('data');
    }

    public function testLikePlaceNotFound()
    {
        $user = factory(User::class)->create();
        $token = \JWTAuth::fromUser($user);

        $response = $this->post('/api/v1/reviews/99999/like', [], ['Authorization' => 'Bearer ' . $token]);

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }
}