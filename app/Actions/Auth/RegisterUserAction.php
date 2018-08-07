<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Responses\RegisterResponse;
use Hedonist\Entities\User\User;
use Hedonist\Exceptions\Auth\EmailAlreadyExistsException;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RegisterRequest $request): void
    {
        $this->validateCanCreateUser($request);
        $user = new User();
        $user->email = $request->getEmail();
        $user->password = Hash::make($request->getPassword());
        $this->repository->save($user);
        Event::dispatch(new Registered($user));
    }

    private function validateCanCreateUser(RegisterRequest $request): void
    {
        if ($this->repository->getByEmail($request->getEmail()) !== null) {
            throw new EmailAlreadyExistsException();
        }
    }
}