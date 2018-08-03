<?php

namespace Hedonist\Actions\Auth;


use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\Auth\Responses\RegisterResponse;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;
use Hedonist\Entities\User;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction implements ActionInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RequestInterface $request):ResponseInterface
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