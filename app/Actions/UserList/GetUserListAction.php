<?php

namespace Hedonist\Actions\UserList;

use App\Exceptions\UserListExceptions\UserListExistsException;

class GetUserListAction
{
    public function execute(GetUserListRequest $userListRequest): GetUserListResponse
    {
        $id = $userListRequest->getId();
        $userList = UserList::find($id);
        if (!$userList) {
            throw new UserListExistsException('User list not found.');
        }
        $responseUserList = new GetUserListResponse($userList);
        return $responseUserList;
    }
}