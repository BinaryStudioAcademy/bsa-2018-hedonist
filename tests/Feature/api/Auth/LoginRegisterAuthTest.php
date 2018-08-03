<?php

namespace Tests\Feature\api\Auth;


use Hedonist\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRegisterAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_register()
    {
        $user = factory(User::class)->make();
        $response = $this->json('POST', '/api/v1/auth/signup',[
            'email' => $user->email,
            'password' => 'secret',
            'name' => $user->name
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['email'=> $user->email]);

    }

    public function test_email_in_use()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/v1/auth/signup',[
            'email' => $user->email,
            'password' => 'secret',
            'name' => $user->name
        ]);
        $response->assertStatus(400);
    }

    public function test_successful_login()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/v1/auth/login',[
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function test_fail_login()
    {
        $user = factory(User::class)->make();
        $response = $this->json('POST', '/api/v1/auth/login',[
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $response->assertStatus(401);
    }
}