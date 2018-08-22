<?php

namespace Tests\Feature\UserInfo;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
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

        $response = $this->json('GET', "/api/v1/users/$userInfo->user_id/info");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "data" =>
                [
                    "user_id" => $userInfo->user_id,
                    "first_name" => $userInfo->first_name,
                    "last_name" => $userInfo->last_name,
                    "date_of_birth" => $userInfo->date_of_birth->format('Y/m/d'),
                    "phone_number" => $userInfo->phone_number,
                    "avatar_url" => $userInfo->avatar_url,
                    "facebook_url" => $userInfo->facebook_url,
                    "instagram_url" => $userInfo->instagram_url,
                    "twitter_url" => $userInfo->twitter_url,
                ]
        ]);
    }

    public function test_update_user_info()
    {
        $userInfo = factory(UserInfo::class)->create();
        $data = [
            'first_name' => "test_first_name",
            'date_of_birth' => '1970/04/12',
            'phone_number' => "380123456789",
            'avatar_url' => $this->avatar
        ];
        $avatarUrl = Storage::url('public/upload/avatar/' . $userInfo->user_id . "." . $this->avatar->extension());

        $response = $this->json('POST', "/api/v1/users/$userInfo->user_id/info", $data);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $response->assertJsonFragment([
            "data" =>
                [
                    "user_id" => $userInfo->user_id,
                    "first_name" => $data['first_name'],
                    "last_name" => $userInfo->last_name,
                    "date_of_birth" => $data['date_of_birth'],
                    "phone_number" => $data['phone_number'],
                    "avatar_url" => $avatarUrl,
                    "facebook_url" => $userInfo->facebook_url,
                    "instagram_url" => $userInfo->instagram_url,
                    "twitter_url" => $userInfo->twitter_url,
                ]
        ]);
    }

    public function test_update_invalid_social()
    {
        $userInfo = factory(UserInfo::class)->create();
        $data = [
            'first_name' => "test_first_name",
            'date_of_birth' => '1970/04/12',
            'phone_number' => "380123456789",
            'avatar_url' => $this->avatar,
            'facebook_url' => "https://twitter.com",
        ];

        $response = $this->json('POST', "/api/v1/users/$userInfo->user_id/info", $data);
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
            'date_of_birth' => '1970/04/12',
            'phone_number' => "380123456789",
            'avatar_url' => $this->avatar,
            'facebook_url' => "https://www.facebook.com/profile.php?id=123456789012345",
            'instagram_url' => "https://www.instagram.com/12345/"
        ];
        $avatarUrl = Storage::url('public/upload/avatar/' . $user->id . "." . $this->avatar->extension());

        $response = $this->json('POST', "/api/v1/users/$user->id/info", $data);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $response->assertJsonFragment([
            "data" =>
                [
                    "user_id" => $user->id,
                    "first_name" => $data['first_name'],
                    "last_name" => $data['last_name'],
                    "date_of_birth" => $data['date_of_birth'],
                    "phone_number" => $data['phone_number'],
                    "avatar_url" => $avatarUrl,
                    "facebook_url" => $data['facebook_url'],
                    "instagram_url" => $data['instagram_url'],
                    "twitter_url" => "",
                ]
        ]);

        $data['avatar_url'] = $avatarUrl;
        $this->assertDatabaseHas('user_info', $data);
    }

    public function test_create_user_info_without_required_field()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'first_name' => "test_first_name",
            'date_of_birth' => '1970/04/12',
            'phone_number' => "380123456789",
            'avatar_url' => $this->avatar,
            'facebook_url' => "https://www.facebook.com/profile.php?id=123456789012345",
            'instagram_url' => "https://www.instagram.com/12345/",
            'twitter_url' => "https://twitter.com/12345"
        ];

        $response = $this->json('POST', "/api/v1/users/$user->id/info", $data);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(400);
    }

    public function test_get_user_list_not_found()
    {
        $this->json('GET', "/api/v1/user/9999/info")->assertStatus(404);
    }
}