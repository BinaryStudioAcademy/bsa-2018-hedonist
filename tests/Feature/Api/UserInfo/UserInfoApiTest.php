<?php

namespace Tests\Feature\UserInfo;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Api\ApiTestCase;

class UserInfoApiTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;
    protected $avatar;

    public function setUp()
    {
        parent::setUp();
        $this->actingWithToken();

        $this->avatar = UploadedFile::fake()->image('test.jpg');
    }

    public function test_get_user_info()
    {
        $userInfo = factory(UserInfo::class)->create();

        $response = $this->json('GET', "/api/v1/users/$userInfo->user_id/info");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($userInfo->user_id, $data['data']['user_id']);
        $this->assertEquals($userInfo->first_name, $data['data']['first_name']);
        $this->assertEquals($userInfo->last_name, $data['data']['last_name']);
        $this->assertEquals($userInfo->date_of_birth->format('Y/m/d'), $data['data']['date_of_birth']);
        $this->assertEquals($userInfo->phone_number, $data['data']['phone_number']);
        $this->assertEquals($userInfo->avatar_url, $data['data']['avatar_url']);
        $this->assertEquals($userInfo->facebook_url, $data['data']['facebook_url']);
        $this->assertEquals($userInfo->instagram_url, $data['data']['instagram_url']);
        $this->assertEquals($userInfo->twitter_url, $data['data']['twitter_url']);
    }

    public function test_update_user_info()
    {
        $userInfo = factory(UserInfo::class)->create();
        $data = [
            'first_name' => 'test_first_name',
            'date_of_birth' => '1970/04/12',
            'phone_number' => '380123456789',
            'avatar_url' => $this->avatar
        ];
        $avatarUrl = $userInfo->user_id . '.' . $this->avatar->extension();

        $response = $this->json('PUT', "/api/v1/users/$userInfo->user_id/info", $data);
        $response->assertStatus(200);
        $result = json_decode($response->getContent(), true);

        $this->assertEquals($result['data']['user_id'], $userInfo->user_id);
        $this->assertEquals($result['data']['first_name'], $data['first_name']);
        $this->assertEquals($result['data']['last_name'], $userInfo->last_name);
        $this->assertEquals($result['data']['date_of_birth'], $data['date_of_birth']);
        $this->assertEquals($result['data']['phone_number'], $data['phone_number']);
        $this->assertEquals($result['data']['avatar_url'], $avatarUrl);
        $this->assertEquals($result['data']['facebook_url'], $userInfo->facebook_url);
        $this->assertEquals($result['data']['instagram_url'], $userInfo->instagram_url);
        $this->assertEquals($result['data']['twitter_url'], $userInfo->twitter_url);
    }

    public function test_update_invalid_social()
    {
        $userInfo = factory(UserInfo::class)->create();
        $data = [
            'first_name' => 'test_first_name',
            'date_of_birth' => '1970/04/12',
            'phone_number' => '380123456789',
            'avatar_url' => $this->avatar,
            'facebook_url' => 'https://twitter.com',
        ];

        $response = $this->json('PUT', "/api/v1/users/$userInfo->user_id/info", $data);

        $response->assertStatus(400);
    }

    public function test_create_user_info()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'first_name' => 'test_first_name',
            'last_name' => 'test_last_name',
            'date_of_birth' => '1970/04/12',
            'phone_number' => '380123456789',
            'avatar_url' => $this->avatar,
            'facebook_url' => 'https://www.facebook.com/profile.php?id=123456789012345',
            'instagram_url' => 'https://www.instagram.com/12345/'
        ];
        $avatarUrl = $user->id . '.' . $this->avatar->extension();

        $response = $this->json('PUT', "/api/v1/users/$user->id/info", $data);
        $response->assertStatus(200);

        $result = json_decode($response->getContent(), true);

        $this->assertEquals($result['data']['user_id'], $user->id);
        $this->assertEquals($result['data']['first_name'], $data['first_name']);
        $this->assertEquals($result['data']['last_name'], $data['last_name']);
        $this->assertEquals($result['data']['date_of_birth'], $data['date_of_birth']);
        $this->assertEquals($result['data']['phone_number'], $data['phone_number']);
        $this->assertEquals($result['data']['avatar_url'], $avatarUrl);
        $this->assertEquals($result['data']['facebook_url'], $data['facebook_url']);
        $this->assertEquals($result['data']['instagram_url'], $data['instagram_url']);
        $this->assertEquals($result['data']['twitter_url'], '');

        $data['avatar_url'] = $avatarUrl;
        $this->assertDatabaseHas('user_info', $data);
    }

    public function test_create_user_info_without_required_field()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'first_name' => 'test_first_name',
            'date_of_birth' => '1970/04/12',
            'phone_number' => '380123456789',
            'avatar_url' => $this->avatar,
            'facebook_url' => 'https://www.facebook.com/profile.php?id=123456789012345',
            'instagram_url' => 'https://www.instagram.com/12345/',
            'twitter_url' => 'https://twitter.com/12345'
        ];

        $response = $this->json('PUT', "/api/v1/users/$user->id/info", $data);
        $response->assertStatus(400);
    }

    public function test_get_user_list_not_found()
    {
        $this->json('GET', '/api/v1/user/9999/info')->assertStatus(404);
    }
}