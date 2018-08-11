<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\GetUserRequest;
use Hedonist\Actions\Auth\Responses\GetUserResponse;
use Hedonist\Exceptions\Auth\InvalidUserDataException;
use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;

class GetUserAction
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

    public function execute(GetUserRequest $request): GetUserResponse
    {
        $user = $this->userRepository->getById($request->getId());
        $userInfo = $this->infoRepository->getByUserId($request->getId());
        if(is_null($user) || is_null($userInfo)){//if there are no user or user data, then throw exception
            throw new InvalidUserDataException();
        }

        return new GetUserResponse($user,$userInfo);
    }
}