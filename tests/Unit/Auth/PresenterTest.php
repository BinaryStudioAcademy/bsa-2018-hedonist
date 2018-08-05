<?php

namespace Tests\Unit\Auth;


use Hedonist\Actions\Auth\Presenters\AuthPresenter;
use Hedonist\Actions\Auth\Responses\AuthenticateResponseInterface;
use Hedonist\Entities\User;
use Tests\TestCase;

class PresenterTest extends TestCase
{
    public function test_auth_response_present()
    {
        $token = str_random(30);
        $mock = $this->createMock(AuthenticateResponseInterface::class);
        $mock->method('getToken')->willReturn($token);
        $result = AuthPresenter::presentAuthenticateResponse($mock);

        $this->assertEquals($token,$result['access_token']);
        $this->assertNotNull($result['token_type']);
        $this->assertNotNull($result['expires_in']);
    }

    public function test_user_present()
    {
        $user = factory(User::class)->make();
        $result = AuthPresenter::presentUser($user);

        $this->assertEquals($result['email'],$user->email);
        $this->assertEquals($result['name'],$user->name);
        $this->assertFalse(isset($result['password']));
    }

    public function test_error_present()
    {
        $message = 'real test message here';
        $exception = new \Exception($message);

        $this->assertEquals($message,AuthPresenter::presentError($exception));
    }
}