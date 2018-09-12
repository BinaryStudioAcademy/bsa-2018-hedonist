<?php

namespace Tests\Feature\Api\Auth;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\Feature\Api\ApiTestCase;
use Tests\TestCase;

class AuthTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_successful_register()
    {
        Event::fake();

        $user = factory(User::class)->make();
        $userInfo = factory(UserInfo::class)->make();
        $response = $this->json('POST', '/api/v1/auth/signup', [
            'email' => $user->email,
            'password' => 'secret',
            'first_name' => $userInfo->first_name,
            'last_name' => $userInfo->last_name,
            'language' => $userInfo->language
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => $user->email]);
        $this->assertDatabaseHas('user_info', [
            'first_name' => $userInfo->first_name,
            'last_name' => $userInfo->last_name
        ]);
        Event::assertDispatched(Registered::class, 1);
    }

    public function test_email_in_use()
    {
        $user = factory(User::class)->create();
        $userInfo = factory(UserInfo::class)->make();

        $response = $this->json('POST', '/api/v1/auth/signup', [
            'email' => $user->email,
            'password' => 'secret',
            'first_name' => $userInfo->first_name,
            'last_name' => $userInfo->last_name,
            'language' => $userInfo->language
        ]);

        $response->assertStatus(400);
    }

    public function test_successful_login()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in'
            ]
        ]);
    }

    public function test_fail_login()
    {
        $user = factory(User::class)->make();
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response->assertStatus(400);
    }

    public function test_wrong_password_login()
    {
        $user = factory(User::class)->make();
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'aaaaaaaaa'
        ]);

        $response->assertStatus(400);
    }

    public function test_refresh_token_unauthenticated()
    {
        $response = $this->json('POST', '/api/v1/auth/refresh');

        $response->assertStatus(401);
    }

    public function test_refresh_token_authenticated()
    {
        $this->authenticate(factory(User::class)->create());
        $response = $this->json('POST',
            'api/v1/auth/refresh');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in'
            ]
        ]);
    }

    public function test_get_authed_user()
    {
        $user = factory(User::class)->create();
        factory(UserInfo::class)->create(['user_id' => $user->id]);
        $this->authenticate($user);
        $response = $this->json('GET', 'api/v1/auth/me');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'first_name',
                'last_name',
                'email',
                'id'
            ]
        ]);
    }

    public function test_logout()
    {
        $user = factory(User::class)->create();
        $this->authenticate($user);
        $response = $this->json('POST', 'api/v1/auth/logout');

        $response->assertStatus(200);

        $response = $this->json('GET', 'api/v1/auth/me');

        $response->assertStatus(401);
    }
}