<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserListApi extends TestCase
{
    use RefreshDatabase;

    public function test_add_user_list()
    {
        $user = factory(User::class)->create();
        $data = [
            'user_id' => $user->id,
            'name' => 'Bar',
            'img_url' => 'image',
        ];
        $response = $this->json('POST','/api/v1/user-list', $data);

        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('user_lists', $data);
    }

    public function test_get_user_list()
    {
        $userList = factory(UserListFactory::class)->create();
        $response = $this->json('GET',"/api/v1/user-list/$userList->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(),true);
        $this->assertEquals($userList->id, $data['id']);
        $this->assertEquals($userList->user_id, $data['user_id']);
        $this->assertEquals($userList->name, $data['name']);
        $this->assertEquals($userList->img_url, $data['img_url']);
    }

    public function test_update_user_list()
    {
        $userList = factory(UserListFactory::class)->create();
        $data = [
            'user_id' => $userList->user_id,
            'name' => 'Caffe',
            'img_url' => 'image',
        ];
        $response = $this->json('PUT',"/api/v1/user-list/$userList->id", $data);
        $result = json_decode($response->getContent(),true);
        $this->assertEquals($result['name'], $data['name']);
    }

    public function test_delete_user_list()
    {
        $userList = factory(UserListFactory::class)->create();

        $response = $this->json('DELETE',"/api/v1/user-list/$userList->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(),true);
        $this->assertEquals($data['result'], 'success');

        $response = $this->json('GET',"/api/v1/user-list/$userList->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(400);
        $response->assertJson(['error' => [
            'message' => 'User list not found.',
            'status_code' => 400,
        ]]);
    }

    public function test_get_all_user_list()
    {
        $userList = [];
        for ($i = 0; $i <= 3; $i++) {
            $userList[] = factory(UserListFactory::class)->create();
        }

        $response = $this->json('GET',"/api/v1/user-list");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(),true);
        $this->assertEquals(count($data), count($userList));
    }

    public function test_get_user_list_not_found()
    {
        $response = $this->json('GET',"/api/v1/user-list/1");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(400);
        $response->assertJson(['error' => [
            'message' => 'User list not found.',
            'status_code' => 400,
        ]]);
    }
}