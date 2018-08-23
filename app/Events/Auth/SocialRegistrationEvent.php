<?php

namespace Hedonist\Events\Auth;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;

class SocialRegistrationEvent
{
    private $user;
    private $userInfo;
    private $password;

    public function __construct(User $user, UserInfo $info, string $password)
    {
        $this->user = $user;
        $this->userInfo = $info;
        $this->password = $password;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserInfo(): UserInfo
    {
        return $this->userInfo;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}