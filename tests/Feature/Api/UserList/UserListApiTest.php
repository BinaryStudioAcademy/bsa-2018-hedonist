<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Api\ApiTestCase;

class UserListApiTest extends ApiTestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingWithToken($this->user);
    }

    public function test_add_user_list()
    {
        Storage::fake();
        $image = UploadedFile::fake()->image('review.jpg');
        $response = $this->json('POST', '/api/v1/user-lists', [
            'name' => 'Bar',
            'image' => $image,
        ]);
        $data = $response->json();
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('user_lists', $data['data']);
    }

    public function test_get_user_list()
    {
        $userList = factory(UserList::class)->create();
        $response = $this->json('GET', "/api/v1/user-lists/$userList->id");
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

    public function test_update_user_list()
    {
        Storage::fake();
        $image = UploadedFile::fake()->image('review.jpg');
        $userList = factory(UserList::class)->create();
        $user = User::find($userList->user_id);
        $data = [
            'name' => 'Caffe',
            'image' => $image,
            'attached_places' => []
        ];
        $response = $this->actingWithToken($user)->json('PUT', "/api/v1/user-lists/$userList->id", $data);
        $result = json_decode($response->getContent(), true);
        $this->assertEquals($result['data']['name'], $data['name']);
    }

    public function test_delete_user_list()
    {
        $userList = factory(UserList::class)->create();
        $user = User::find($userList->user_id);
        $this->actingWithToken($user)->json('DELETE', "/api/v1/user-lists/$userList->id");

        $this->json('GET', "/api/v1/user-lists/$userList->id")->assertStatus(404);
    }

    public function test_get_all_user_list()
    {
        $userList = [];
        for ($i = 0; $i < 3; $i++) {
            $userList[] = factory(UserList::class)->create();
        }

        $response = $this->json('GET', "/api/v1/user-lists");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(count($data['data']), count($userList));
    }

    public function test_get_user_list_not_found()
    {
        $this->json('GET', "/api/v1/user-lists/9090")->assertStatus(404);
    }
}