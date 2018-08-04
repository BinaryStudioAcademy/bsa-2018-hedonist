<?php

namespace Hedonist\Actions;

use Hedonist\Actions\Auth\Requests\LoginRequest;
use Hedonist\Actions\Auth\Responses\LoginResponse;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(LoginRequest $request): LoginResponse
    {
        $credentials = [
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ];

        $token = JWTAuth::attempt($credentials);//returns false if attempt falis
        if (!$token) {
            throw new AuthenticationException();
        }

        return new LoginResponse($token);
    }
}