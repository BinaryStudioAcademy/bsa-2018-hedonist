<?php

namespace Hedonist\Actions;


use Hedonist\Actions\Auth\LoginUserActionInterface;
use Hedonist\Actions\Auth\Requests\LoginRequestInterface;
use Hedonist\Actions\Auth\Responses\LoginResponse;
use Hedonist\Actions\Auth\Responses\LoginResponseInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction implements LoginUserActionInterface
{
    private $repository;
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(LoginRequestInterface $request):LoginResponseInterface
    {
        $credentials = [
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ];
        if(! $token = JWTAuth::attempt($credentials)){
            throw new AuthenticationException();
        }
        return new LoginResponse($token);
    }
}