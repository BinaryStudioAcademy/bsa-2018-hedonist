<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\User;

class GetUserInfoResponse
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}