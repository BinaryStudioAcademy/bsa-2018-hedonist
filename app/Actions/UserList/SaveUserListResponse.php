<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Actions\ResponseInterface;

class SaveUserListResponse implements ResponseInterface
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