<?php

namespace Hedonist\Actions\Auth;


use Hedonist\Actions\Auth\Requests\RegisterRequestInterface;
use Hedonist\Actions\Auth\Responses\RegisterResponse;
use Hedonist\Actions\Auth\Responses\RegisterResponseInterface;
use Hedonist\Entities\User;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction implements RegisterUserActionInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RegisterRequestInterface $request):RegisterResponseInterface
    {
        $user = new User();
        $user->email = $request->getEmail();
        $user->password = Hash::make($request->getPassword());
        $user->name = $request->getName();
        $this->repository->save($user);
        event(new Registered($user));
        return new RegisterResponse(false);
    }
}