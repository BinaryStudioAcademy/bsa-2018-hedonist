<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Exceptions\UserList\UserListExistsException;
use Hedonist\Repositories\UserList\UserListRepository;

class GetUserListAction
{
    private $userListRepository;

    public function __construct(UserListRepository $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(GetUserListRequest $userListRequest): GetUserListResponse
    {
        $id = $userListRequest->getId();
        $userList = $this->userListRepository->getById($id);
        if (!$userList) {
            throw new UserListExistsException('User list not found.');
        }

        return new GetUserListResponse($userList);
    }
}