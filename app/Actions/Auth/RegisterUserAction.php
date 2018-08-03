<?php

namespace Hedonist\Actions\Auth;


use Hedonist\Actions\Auth\Requests\RegisterUserRequestInterface;
use Hedonist\Entities\User;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterUserAction implements RegisterUserActionInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RegisterUserRequestInterface $request)
    {
        if($this->repository->getByEmail($request->getEmail()) !== null){
            throw new \LogicException("User with this email already exists!");
        }
        $user = new User();
        $user->email = $request->getEmail();
        $user->password = Hash::make($request->getPassword());
        $this->repository->save($user);
        event(new Registered($user));
    }
}