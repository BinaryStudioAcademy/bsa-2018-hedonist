<?php

namespace Hedonist\Actions\UserList;

class SaveUserListResponse
{
    private $userList;

    public function __construct($userList)
    {
        $this->userList = $userList;
    }

    public function getModel()
    {
        return $this->userList;
    }
}