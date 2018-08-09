<?php

namespace tests\Feature\Api\Place;

use Hedonist\Entities\Place\Checkin;
use Hedonist\Entities\Place\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;
use Hedonist\Entities\User\User;

class CheckinTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;
    protected $place;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->place = factory(Place::class)->create();

        $this->actingWithToken($this->user);
    }

    public function test_checkin() : void
    {
        $placeId = $this->place->id;
        $userId = $this->user->id;

        $this->assertDatabaseMissing('user_place_checkin', [
            'place_id' => $placeId,
            'user_id' => $userId,
        ]);

        $response = $this->json('POST', route('user.me.checkin'), [
            'place_id' => $placeId,
        ]);

        $id = $response->getOriginalContent()['data']['id'];

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'data' => [
                'id' => $id,
                'place_id' => $placeId,
                'user_id' => $userId,
            ]
        ]);
        $this->assertDatabaseHas('user_place_checkin', [
            'id' => $id,
            'place_id' => $placeId,
            'user_id' => $userId,
        ]);

        // assert that in DB new row created
        $response = $this->json('POST', route('user.me.checkin'), [
            'place_id' => $placeId,
        ]);
        $id = $response->getOriginalContent()['data']['id'];
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'data' => [
                'id' => $id,
                'place_id' => $placeId,
                'user_id' => $userId,
            ]
        ]);
        $this->assertEquals(2, Checkin::where([
                ['place_id', $placeId],
                ['user_id', $userId],
            ])->count()
        );

        $response = $this->json('POST', route('user.me.checkin'), [
            'place_id' => 9999,
        ]);

        $response->assertJsonFragment([
            'error'=>[
                'httpStatus'=>400,
                'message'=>'Place not found'
            ]
        ]);
    }
}