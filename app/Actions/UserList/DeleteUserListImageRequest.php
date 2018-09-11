<?php

namespace Hedonist\Actions\UserList;

class DeleteUserListImageRequest
{
    private $userListId;

    public function __construct(int $userListId)
    {
        $this->userListId = $userListId;
    }

    public function getUserListId(): int
    {
        return $this->userListId;
    }
}