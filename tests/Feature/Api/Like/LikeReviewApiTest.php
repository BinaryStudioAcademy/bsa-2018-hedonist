<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class LikeReviewApiTest extends ApiTestCase
{
    use RefreshDatabase;

    public function testLikeReviewNotFound()
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