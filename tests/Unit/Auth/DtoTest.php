<?php

namespace Tests\Unit\Auth;


use Hedonist\Actions\Auth\Requests\LoginRequest;
use Hedonist\Actions\Auth\Requests\RecoverPasswordRequest;
use Hedonist\Actions\Auth\Requests\ResetPasswordRequest;
use Hedonist\Actions\Auth\Responses\LoginResponse;
use Hedonist\Actions\Auth\Responses\RefreshResponse;
use Hedonist\Actions\Auth\Responses\RegisterResponse;
use Hedonist\Actions\Auth\Responses\ResetPasswordResponse;
use Hedonist\Entities\User\User;
use Hedonist\Requests\Auth\RegisterRequest;
use Tests\TestCase;

class DtoTest extends TestCase
{
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->make();
    }

    public function test_register_request()
    {

        $request = new RegisterRequest($this->user->email, 'secret', $this->user->name);

        $this->assertEquals($this->user->email, $request->getEmail());
        $this->assertEquals('secret', $request->getPassword());
        $this->assertEquals($this->user->name, $request->getName());
    }

    public function test_login_request()
    {
        $request = new LoginRequest($this->user->email, 'secret');

        $this->assertEquals($this->user->email, $request->getEmail());
        $this->assertEquals('secret', $request->getPassword());
    }

    public function test_recover_password_request()
    {
        $request = new RecoverPasswordRequest($this->user->email);

        $this->assertEquals($this->user->email, $request->getEmail());
    }

    public function test_reset_password_request()
    {
        $pwd = 'secret';
        $confirm_pwd = 'not_secret';
        $token = str_random(30);
        $request = new ResetPasswordRequest(
            $this->user->email,
            $pwd,
            $confirm_pwd,
            $token
        );

        $this->assertEquals($this->user->email, $request->getEmail());
        $this->assertEquals($pwd, $request->getPassword());
        $this->assertEquals($confirm_pwd, $request->getPasswordConfirmation());
        $this->assertEquals($token, $request->getToken());
    }

    public function test_login_response()
    {
        $token = str_random(30);
        $response = new LoginResponse($token);

        $this->assertEquals($token, $response->getToken());
    }

    public function test_refresh_response()
    {
        $token = str_random(30);
        $response = new ResetPasswordResponse($token);

        $this->assertEquals($token, $response->getToken());
    }

    public function test_reset_response()
    {
        $token = str_random(30);
        $response = new RefreshResponse($token);

        $this->assertEquals($token, $response->getToken());
    }
}