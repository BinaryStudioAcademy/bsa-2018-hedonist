<?php

namespace Hedonist\Actions\Auth\Responses;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;

class GetUserResponse
{
    private $userInfo;
    private $user;

    public function __construct(User $user, UserInfo $userInfo)
    {
        $this->user = $user;
        $this->userInfo = $userInfo;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserInfo(): UserInfo
    {
        return $this->userInfo;
    }
}