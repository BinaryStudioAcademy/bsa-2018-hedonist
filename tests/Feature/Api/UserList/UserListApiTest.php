<?php

namespace Tests\Feature;

use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class UserListApiTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingWithToken($this->user);
    }

    public function test_add_user_list()
    {
        $data = [
            'user_id' => $this->user->id,
            'name' => 'Bar',
            'img_url' => 'http://test.image',
        ];
        $response = $this->json('POST', '/api/v1/user-list', $data);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('user_lists', $data);
    }

    public function test_get_user_list()
    {
        $userList = factory(UserList::class)->create();
        $response = $this->json('GET', "/api/v1/user-list/$userList->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($userList->id, $data['data']['id']);
        $this->assertEquals($userList->user_id, $data['data']['user_id']);
        $this->assertEquals($userList->name, $data['data']['name']);
        $this->assertEquals($userList->img_url, $data['data']['img_url']);
    }

    public function test_get_user_lists()
    {
        $userLists = factory(UserList::class)->create();
        $response = $this->json('GET', "/api/v1/users/$userLists->user_id/lists");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $response->assertJsonStructure(
            ["data" =>
                [
                    '*' => [
                        "id",
                        "user_id",
                        "name",
                        "img_url"
                    ]
                ]
            ]);
    }

    public function test_get_empty_user_lists()
    {
        $userLists = factory(UserList::class)->create([
            "name" => '',
            "img_url" => ''
        ]);
        $response = $this->json('GET', "/api/v1/user-list/$userLists->id");
        $response->assertHeader('Content-Type', 'application/json');
        if(empty($response->json())){
            $response->json()->assertStatus(404);
        }
    }

    public function test_update_user_list()
    {
        $userList = factory(UserList::class)->create();
        $data = [
            'user_id' => $userList->user_id,
            'name' => 'Caffe',
            'img_url' => 'http://test.image',
        ];
        $response = $this->json('PUT', "/api/v1/user-list/$userList->id", $data);
        $result = json_decode($response->getContent(), true);
        $this->assertEquals($result['data']['name'], $data['name']);
    }

    public function test_delete_user_list()
    {
        $userList = factory(UserList::class)->create();
        $this->json('DELETE', "/api/v1/user-list/$userList->id");

        $this->json('GET', "/api/v1/user-list/$userList->id")->assertStatus(404);
    }

    public function test_get_all_user_list()
    {
        $userList = [];
        for ($i = 0; $i < 3; $i++) {
            $userList[] = factory(UserList::class)->create();
        }

        $response = $this->json('GET', "/api/v1/user-list");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(count($data['data']), count($userList));
    }

    public function test_get_user_list_not_found()
    {
        $this->json('GET', "/api/v1/user-list/1")->assertStatus(404);
    }
}