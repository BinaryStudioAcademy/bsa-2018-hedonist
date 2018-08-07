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

    public function getModel()
    {
        return $this->userList;
    }

    public function toArray()
    {
        return $this->userList->toArray();
    }
}