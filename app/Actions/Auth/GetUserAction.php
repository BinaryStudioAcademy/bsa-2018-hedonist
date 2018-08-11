<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\GetUserRequest;
use Hedonist\Actions\Auth\Responses\GetUserResponse;
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
        return new GetUserResponse(
            $this->userRepository->getById($request->getId()),
            $this->infoRepository->getByUserId($request->getId())
        );
    }
}