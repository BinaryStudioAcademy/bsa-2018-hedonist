<?php

namespace Hedonist\Actions\User\Follows;

use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class FollowUserAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(FollowUserRequest $request): void
    {
        $followed = $this->repository->getById($request->getFollowedId());
        if(is_null($followed)){
            throw new UserNotFoundException();
        }
        $this->repository->followUser($followed, Auth::user());
    }
}