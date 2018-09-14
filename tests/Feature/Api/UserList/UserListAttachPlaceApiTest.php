<?php

namespace Tests\Feature\Api\UserList;

use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class UserListAttachPlaceApiTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;
    protected $user2;
    protected $token;
    protected $userList;
    protected $userList2;
    protected $place;

    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        $this->user2 = factory(User::class)->create();
        $this->token = \JWTAuth::fromUser($this->user);

        $this->userList = factory(UserList::class)->create();
        $this->userList->user_id = $this->user->id;
        $this->userList->save();

        $this->userList2 = factory(UserList::class)->create();
        $this->userList2->user_id = $this->user2->id;
        $this->userList2->save();

        $this->place = factory(Place::class)->create();
    }

    public function testUserListNotFound()
    {
        $response = $this->post(
            "/api/v1/user-lists/99999/attach-place",
            ['id' => $this->place->id],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertHeader('Content-Type', 'application/json')
            ->assertStatus(400);
    }

    public function testPlaceNotFound()
    {
        $response = $this->post(
            "/api/v1/user-lists/{$this->userList->id}/attach-place",
            ['id' => 99999],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertHeader('Content-Type', 'application/json')
            ->assertStatus(400);
    }

    public function testNonAuthorized()
    {
        $response = $this->post(
            "/api/v1/user-lists/{$this->userList2->id}/attach-place",
            ['id' => $this->place->id],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertHeader('Content-Type', 'application/json')
            ->assertStatus(400);
    }

    public function testAttachPlace()
    {
        $response = $this->post(
            "/api/v1/user-lists/{$this->userList->id}/attach-place",
            ['id' => $this->place->id],
            ['Authorization' => 'Bearer ' . $this->token]
        );
        
        $response->assertHeader('Content-Type', 'application/json')
            ->assertStatus(201);
        
        $this->assertDatabaseHas('user_list_places', [
            'list_id' => $this->userList->id,
            'place_id' => $this->place->id
        ]);
    }

    public function testAttachPlaceToFavourite()
    {
        $response = $this->actingWithToken($this->user)->json(
            'POST',
            "/api/v1/user-lists/favourite",
            ['id' => $this->place->id]
        );
        $response->assertHeader('Content-Type', 'application/json')
            ->assertStatus(201);
        
        $this->assertDatabaseHas('user_list_places', [
            'place_id' => $this->place->id
        ]);
    }
}
