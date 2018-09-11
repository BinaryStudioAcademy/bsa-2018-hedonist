<?php

namespace Hedonist\Actions\User\Follows;

use Hedonist\Events\Follows\UserFollowed;
use Hedonist\Exceptions\User\FollowYourselfException;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Notifications\UserFollowNotification;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class FollowUserAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(FollowUserRequest $request): void
    {
        if ($request->getFollowedId() === Auth::id()) {
            throw FollowYourselfException::create();
        }
        $followed = $this->repository->getById($request->getFollowedId());
        if (is_null($followed) || !$this->repository->checkUserCanFollow($followed, Auth::user())) {
            throw new UserNotFoundException();
        }
        $this->repository->followUser($followed, Auth::user());
        Event::dispatch(new UserFollowed($followed, Auth::user()));
        if ((bool) $followed->info->notifications_receive === true) {
            $followed->notify(new UserFollowNotification(Auth::user()));
        }
    }
}