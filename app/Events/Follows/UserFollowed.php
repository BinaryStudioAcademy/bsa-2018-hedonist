<?php

namespace Hedonist\Events\Follows;

use Illuminate\Foundation\Auth\User;

class UserFollowed
{
    private $followedUser;
    private $follower;

    public function __construct(User $followedUser, User $follower)
    {
        $this->followedUser = $followedUser;
        $this->follower = $follower;
    }

    public function getFollowedUser(): User
    {
        return $this->followedUser;
    }

    public function getFollower(): User
    {
        return $this->follower;
    }
}