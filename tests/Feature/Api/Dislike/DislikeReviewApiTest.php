<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class DislikeReviewApiTest extends ApiTestCase
{
    use RefreshDatabase;

    public function testDislikeReviewNotFound()
    {
        $user = factory(User::class)->create();
        $token = \JWTAuth::fromUser($user);

        $response = $this->post('/api/v1/reviews/99999/dislike', [], ['Authorization' => 'Bearer ' . $token]);

        $content = $response->getContent();
        echo(substr($content,0,500));

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }
}