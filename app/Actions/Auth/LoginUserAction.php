<?php

namespace Hedonist\Actions;

use Hedonist\Actions\Auth\Requests\LoginRequest;
use Hedonist\Actions\Auth\Responses\LoginResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class LoginUserAction
{
    public function execute(LoginRequest $request): LoginResponse
    {
        $credentials = [
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ];

        $token = Auth::attempt($credentials);
        if (!$token) {
            throw new AuthenticationException();
        }

        return new LoginResponse($token);
    }
}