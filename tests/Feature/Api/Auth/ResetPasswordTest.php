<?php

namespace Tests\Feature\Api\Auth;

use Hedonist\Entities\User\User;
use Hedonist\Events\Auth\PasswordResetedEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    private $token;
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }


    public function test_reset_password()
    {
        Event::fake();

        $response = $this->json('POST', '/api/v1/auth/recover', ['email' => $this->user->email]);

        Event::assertDispatched(PasswordResetedEvent::class, function ($e) {
            $this->token = $e->getToken();
            return true;
        });

        $this->assertDatabaseHas('password_resets', ['email' => $this->user->email]);
        $response->assertStatus(200);

        $response = $this->json('POST', '/api/v1/auth/reset', [
            'email' => $this->user->email,
            'token' => $this->token,
            'password' => '123456',
            'password_confirmation' => '123456'
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

    public function test_fake_email()
    {
        $user = factory(User::class)->make();
        $response = $this->json('POST', '/api/v1/auth/recover', ['email' => $user->email]);

        $response->assertStatus(400);
    }

    public function test_incorrect_token()
    {
        $this->json('POST', '/api/v1/auth/recover', ['email' => $this->user->email]);
        $response = $this->json('POST', '/api/v1/auth/reset', [
            'email' => $this->user->email,
            'token' => 'a7yrf2',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertStatus(400);
    }

    public function test_change_password_success()
    {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'secret'
        ]);
        $token = $response->json('data')['access_token'];

        $response = $this->json('POST',
            'api/v1/auth/change',
            [
                'old_password' => 'secret',
                'new_password' => 'new_secret'
            ],
            ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $response = $this->json('GET',
            'api/v1/auth/me',
            [],
            ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $this->assertTrue(Hash::check('new_secret', User::find($this->user->id)->password));
    }

    public function test_change_password_fail()
    {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'secret'
        ]);
        $token = $response->json('data')['access_token'];

        $response = $this->json('POST',
            'api/v1/auth/change',
            [
                'old_password' => 'not_secret',
                'new_password' => 'new_secret'
            ],
            ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(400);
    }
}