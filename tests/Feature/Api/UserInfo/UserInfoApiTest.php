<?php

namespace Tests\Feature\UserInfo;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Hedonist\Services\FileNameGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Api\ApiTestCase;

class UserInfoApiTest extends ApiTestCase
{
    use RefreshDatabase;

    private $avatar;

    public function setUp()
    {
        parent::setUp();
        $this->actingWithToken();

        $this->avatar = UploadedFile::fake()->image('test.jpg');
    }

    public function test_get_user_info()
    {
        $userInfo = factory(UserInfo::class)->create();

        $response = $this->json('GET', "/api/v1/users/$userInfo->user_id/profile");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $result = $response->getOriginalContent();
        $this->assertEquals($userInfo->user_id, $result['data']['id']);
        $this->assertEquals($userInfo->first_name, $result['data']['first_name']);
        $this->assertEquals($userInfo->last_name, $result['data']['last_name']);
        $this->assertEquals($userInfo->date_of_birth->format('Y/m/d'), $result['data']['date_of_birth']);
        $this->assertEquals($userInfo->phone_number, $result['data']['phone_number']);
        $this->assertEquals($userInfo->avatar_url, $result['data']['avatar_url']);
        $this->assertEquals($userInfo->facebook_url, $result['data']['facebook_url']);
        $this->assertEquals($userInfo->instagram_url, $result['data']['instagram_url']);
        $this->assertEquals($userInfo->twitter_url, $result['data']['twitter_url']);
    }

    public function test_update_user_info()
    {
        $userInfo = factory(UserInfo::class)->create();
        $data = [
            'first_name' => "test_first_name",
            'date_of_birth' => '1970/04/13',
            'phone_number' => "380123456789",
            'notifications_receive' => true,
            'is_private' => false
        ];
        $response = $this->json('POST', "/api/v1/users/$userInfo->user_id/profile", $data);

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $result = $response->getOriginalContent();

        $this->assertEquals($userInfo->user_id, $result['data']['user_id']);
        $this->assertEquals($data['first_name'], $result['data']['first_name']);
        $this->assertEquals($userInfo->last_name, $result['data']['last_name']);
        $this->assertEquals($data['date_of_birth'], $result['data']['date_of_birth']->format('Y/m/d'));
        $this->assertEquals($data['phone_number'], $result['data']['phone_number']);
        $this->assertEquals($userInfo->avatar_url, $result['data']['avatar_url']);
        $this->assertEquals(null, $result['data']['facebook_url']);
        $this->assertEquals(null, $result['data']['instagram_url']);
        $this->assertEquals(null, $result['data']['twitter_url']);
    }

    public function test_update_invalid_social()
    {
        $userInfo = factory(UserInfo::class)->create();
        $data = [
            'first_name' => "test_first_name",
            'date_of_birth' => '1970/04/12',
            'phone_number' => "380123456789",
            'avatar' => $this->avatar,
            'facebook_url' => "https://twitter.com",
            'notifications_receive' => true,
            'is_private' => false
        ];

        $response = $this->json('POST', "/api/v1/users/$userInfo->user_id/profile", $data);
        $response->assertHeader('Content-Type', 'application/json');

        $response->assertStatus(400);
    }

    public function test_create_user_info()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'first_name' => "test_first_name",
            'last_name' => "test_last_name",
            'date_of_birth' => '1970/04/13',
            'phone_number' => "380123456789",
            'avatar' => $this->avatar,
            'facebook_url' => "https://www.facebook.com/profile.php?id=123456789012345",
            'instagram_url' => "https://www.instagram.com/12345/",
            'notifications_receive' => true,
            'is_private' => false
        ];
        $response = $this->json('POST', "/api/v1/users/$user->id/profile", $data);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $result = $response->getOriginalContent();
        $this->assertEquals($user->id, $result['data']['user_id']);
        $this->assertEquals($data['first_name'], $result['data']['first_name']);
        $this->assertEquals($data['last_name'], $result['data']['last_name']);
        $this->assertEquals($data['date_of_birth'], $result['data']['date_of_birth']->format('Y/m/d'));
        $this->assertEquals($data['phone_number'], $result['data']['phone_number']);
        $this->assertEquals($user->info->avatar_url, $result['data']['avatar_url']);
        $this->assertEquals($data['facebook_url'], $result['data']['facebook_url']);
        $this->assertEquals($data['instagram_url'], $result['data']['instagram_url']);
        $this->assertEquals("", $result['data']['twitter_url']);
    }

    public function test_create_user_info_without_required_field()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'first_name' => "test_first_name",
            'date_of_birth' => '1970/04/12',
            'phone_number' => "380123456789",
            'avatar' => $this->avatar,
            'facebook_url' => "https://www.facebook.com/profile.php?id=123456789012345",
            'instagram_url' => "https://www.instagram.com/12345/",
            'twitter_url' => "https://twitter.com/12345",
            'notifications_receive' => true,
            'is_private' => false
        ];

        $response = $this->json('POST', "/api/v1/users/$user->id/profile", $data);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(400);
    }

    public function test_get_user_info_not_found()
    {
        $this->json('GET', "/api/v1/user/9999/profile")->assertStatus(404);
    }

    public function test_delete_user_avatar_url()
    {
        $userInfo = factory(UserInfo::class)->create();
        $data = [
            'id' => $userInfo->id,
            'user_id' => $userInfo->user_id,
            'avatar_url' => '',
        ];
        $this->json('DELETE', "/api/v1/users/$userInfo->user_id/profile/avatar");
        $this->assertDatabaseHas('user_info', $data);
    }
}