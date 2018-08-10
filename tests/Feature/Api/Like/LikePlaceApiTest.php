<?php

namespace Tests\Feature\Api\Like;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\Api\ApiTestCase;

class LikePlaceApiTest extends ApiTestCase
{
    use RefreshDatabase;

    private $placeId;
    private $user;
    private $endpoint;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->placeId = factory(Place::class)->create()->id;
        $this->endpoint = preg_replace('/{.*}/', $this->placeId, '/api/v1/places/{id}/like');
    }

    public function testLikePlaceNotFound()
    {
        $response = $this->actingWithToken()->post('/api/v1/places/99999/like');

        $response->assertHeader('Content-Type', 'application/json')
            ->assertNotFound()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testAddLike()
    {
        $response = $this->actingWithToken()->post($this->endpoint);

        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $this->placeId,
            'likeable_type' => Place::class,
            'user_id' => Auth::id()
        ]);
    }

    public function testAddLikeTwice()
    {
        $response = $this->actingWithToken($this->user)->post($this->endpoint);

        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $this->placeId,
            'likeable_type' => Place::class,
            'user_id' => $this->user->id
        ]);

        $responseTwo = $this->actingWithToken($this->user)->post($this->endpoint);

        $responseTwo->assertStatus(200);
        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $this->placeId,
            'likeable_type' => Place::class,
            'user_id' => $this->user->id
        ]);
    }

    public function testLikeDisliked()
    {
        $response = $this->actingWithToken($this->user)->post("/api/v1/places/{$this->placeId}/dislike");

        $response->assertStatus(200);
        $this->assertDatabaseHas('dislikes', [
            'dislikeable_id' => $this->placeId,
            'dislikeable_type' => Place::class,
            'user_id' => $this->user->id
        ]);

        $responseTwo = $this->actingWithToken($this->user)->post($this->endpoint);

        $responseTwo->assertStatus(200);
        $this->assertDatabaseMissing('dislikes', [
            'dislikeable_id' => $this->placeId,
            'dislikeable_type' => Place::class,
            'user_id' => $this->user->id
        ]);
        $this->assertDatabaseHas('likes', [
            'likeable_id' => $this->placeId,
            'likeable_type' => Place::class,
            'user_id' => $this->user->id
        ]);
    }
}