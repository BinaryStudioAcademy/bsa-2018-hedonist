<?php

namespace Hedonist\Services\UserList;

use Hedonist\Request\UserList\UserListRequestInterface;
use Illuminate\Support\Collection;

interface UserListServiceInterface
{
    public function getCollection(): Collection;

    public function getUserList(int $id);

    public function save(UserListRequestInterface $userListRequest);
}