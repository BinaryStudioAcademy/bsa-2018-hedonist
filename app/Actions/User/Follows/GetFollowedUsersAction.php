<?php

namespace Hedonist\Actions\User\Follows;


use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetFollowedUsersAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetFollowedUsersRequest $request): GetFollowedUsersResponse
    {
        $user = $this->repository->getById($request->getUserId());
        if(is_null($user)){
            throw new UserNotFoundException();
        }
        $users = $this->repository->getFollowedUsers($user);

        return new GetFollowedUsersResponse($users);
    }
}