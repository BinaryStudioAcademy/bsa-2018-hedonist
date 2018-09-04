<?php

namespace Hedonist\Actions\User\Follows;

use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Repositories\User\UserRepositoryInterface;

class GetFollowersAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetFollowersRequest $request)
    {
        $user = $this->repository->getById($request->getUserId());
        if(is_null($user)){
            throw new UserNotFoundException();
        }
        $users = $this->repository->getFollowers($user);

        return new GetFollowersResponse($users);
    }
}