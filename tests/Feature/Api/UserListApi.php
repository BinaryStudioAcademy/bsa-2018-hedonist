<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserListApi extends TestCase
{
    use RefreshDatabase;

    public function test_add_user_list()
    {
        $time = time();
        $userList = factory(UserListFactory::class)->create();
        $response = $this->json('POST','/api/v1/user-list', [
            'id' => $userList->id,
            'user_id' => $userList->user_id,
            'name' => $userList->name,
            'img_url' => $userList->img_url,
        ]);

        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('user_lists', [
            'id' => $userList->id,
            'user_id' => $userList->user_id,
            'name' => $userList->name,
            'img_url' => $userList->img_url,
        ]);
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

    }

    public function test_delete_user_list()
    {

    }

    public function test_get_all_user_list()
    {
        factory(UserListFactory::class, 3)->create();
        $response = $this->json('GET',"/api/v1/user-list");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
    }
}