<?php

namespace Hedonist\Services\UserList;

use App\Exceptions\UserListExceptions\UserListExistsException;
use Hedonist\Request\UserList\UserListRequestInterface;
use Illuminate\Support\Collection;

class UserListService implements UserListServiceInterface
{
    private $userList;

    public function __construct($userList)
    {
        $this->userList = $userList;
    }

    public function getCollection(): Collection
    {
        return $this->userList->findAll();
    }

    public function getUserList(int $id)
    {
        $userList = $this->userList->getById($id);
        if (!$userList) {
            throw new UserListExistsException('User List does not exist.');
        }
        return $userList;
    }

    public function save(UserListRequestInterface $userListRequest, int $id = null)
    {
        if ($id) {
            $userList = $this->getUserList($id);
        } else {
            $userList = new UserList;
        }
        $userList->user_id = $userListRequest->getUserId();
        $userList->name = $userListRequest->getName();
        $userList->img_url = $userListRequest->getImgUrl();
        return $this->userList->save($userList);
    }
}