<?php

namespace Hedonist\Actions;


use Hedonist\Actions\Auth\LoginUserActionInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Tymon\JWTAuth\JWTAuth;

class LoginUserAction implements LoginUserActionInterface
{
    private $repository;
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(LoginUserRequestInterface $request)
    {
        $credentials = [
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ];
        return JWTAuth::attempt($credentials);
    }
}