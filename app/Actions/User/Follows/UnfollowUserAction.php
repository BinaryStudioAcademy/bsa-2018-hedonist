<?php

namespace Hedonist\Actions\User\Follows;

use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Notifications\UserUnfollowNotification;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UnfollowUserAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UnfollowUserRequest $request): void
    {
        $followed = $this->repository->getById($request->getFollowedId());
        if (is_null($followed)) {
            throw new UserNotFoundException();
        }
        $this->repository->unfollowUser($followed, Auth::user());
        if ((bool) $followed->info->notifications_receive === true) {
            $followed->notify(new UserUnfollowNotification(Auth::user()));
        }
    }
}