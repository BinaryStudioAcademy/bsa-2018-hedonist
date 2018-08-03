<?php

namespace Hedonist\Actions\UserList;

use App\Exceptions\UserListExceptions\UserListExistsException;
use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;

class GetUserListAction implements ActionInterface
{
    public function execute(RequestInterface $userListRequest): ResponseInterface
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