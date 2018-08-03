<?php

namespace Hedonist\Actions;


use Hedonist\Actions\Auth\Responses\LoginResponse;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction implements ActionInterface
{
    private $repository;
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RequestInterface $request):ResponseInterface
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