<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;

class SaveUserListResponse
{
    private $userList;

    public function __construct(UserList $userList)
    {
        $this->userList = $userList;
    }

    public function getModel(): UserList
    {
        return $this->userList;
    }

    public function toArray(): array
    {
        return $this->userList->toArray();
    }
}