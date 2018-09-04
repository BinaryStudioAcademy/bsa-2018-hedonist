<?php

namespace Hedonist\Http\Controllers\Api\User;

use Hedonist\Actions\Presenters\User\UserPresenter;
use Hedonist\Actions\User\Follows\FollowUserAction;
use Hedonist\Actions\User\Follows\FollowUserRequest;
use Hedonist\Actions\User\Follows\GetFollowedUsersAction;
use Hedonist\Actions\User\Follows\GetFollowedUsersRequest;
use Hedonist\Actions\User\Follows\GetFollowersAction;
use Hedonist\Actions\User\Follows\GetFollowersRequest;
use Hedonist\Actions\User\Follows\UnfollowUserAction;
use Hedonist\Actions\User\Follows\UnfollowUserRequest;
use Hedonist\Exceptions\DomainException;
use Hedonist\Http\Controllers\Api\ApiController;

class UserFollowsController extends ApiController
{
    public function getFollowers(int $userId, GetFollowersAction $action, UserPresenter $presenter)
    {
        try {
            $result = $action->execute(new GetFollowersRequest($userId));

            return $this->successResponse($presenter->presentCollection($result->getUsers()));
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function getFollowedUsers(int $userId, GetFollowedUsersAction $action, UserPresenter $presenter)
    {
        try {
            $result = $action->execute(new GetFollowedUsersRequest($userId));

            return $this->successResponse($presenter->presentCollection($result->getUsers()));
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function followUser(int $userId, FollowUserAction $action)
    {
        try {
            $action->execute(new FollowUserRequest($userId));

            return $this->emptyResponse(200);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function unfollowUser(int $userId, UnfollowUserAction $action)
    {
        try {
            $action->execute(new UnfollowUserRequest($userId));

            return $this->emptyResponse(200);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
