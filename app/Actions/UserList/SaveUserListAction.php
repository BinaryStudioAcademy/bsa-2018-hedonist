<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;
use Hedonist\Repositories\UserList\UserListRepository;

class SaveUserListAction
{
    private $userListRepository;

    public function __construct(UserListRepository $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(SaveUserListRequest $userListRequest): SaveUserListResponse
    {
        $id = $userListRequest->getId();
        if (! $id) {
            $userList = new UserList;
        } else {
            $userList = $this->userListRepository->getById($id);
        }

        $userList->user_id = $userListRequest->getUserId();
        $userList->name = $userListRequest->getName();
        $userList->img_url = $userListRequest->getImgUrl();

        $userList = $this->userListRepository->save($userList);

        return new SaveUserListResponse($userList);
    }
}