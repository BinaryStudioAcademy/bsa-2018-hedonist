<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Hedonist\Exceptions\Auth\EmailAlreadyExistsException;
use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    private $userRepository;
    private $infoRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserInfoRepositoryInterface $infoRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->infoRepository = $infoRepository;
    }

    public function execute(RegisterRequest $request): void
    {
        $this->validateCanCreateUser($request);
        $user = new User();
        $user->email = $request->getEmail();
        $user->password = Hash::make($request->getPassword());
        $user = $this->userRepository->save($user);

        $userInfo = new UserInfo();
        $userInfo->user_id = $user->getKey();
        $userInfo->first_name = $request->getFirstName();
        $userInfo->last_name = $request->getLastName();
        $this->infoRepository->save($userInfo);

        Event::dispatch(new Registered($user));
    }

    private function validateCanCreateUser(RegisterRequest $request): void
    {
        if ($this->userRepository->getByEmail($request->getEmail()) !== null) {
            throw new EmailAlreadyExistsException();
        }
    }
}