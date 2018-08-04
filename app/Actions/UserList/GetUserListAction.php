<?php

namespace Hedonist\Actions\UserList;

use App\Exceptions\UserListExceptions\UserListExistsException;
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
        $responseUserList = new GetUserListResponse($userList);
        return $responseUserList;
    }
}