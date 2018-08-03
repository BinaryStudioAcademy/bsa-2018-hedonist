<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;

class GetUserListAction implements ActionInterface
{
    public function execute(RequestInterface $userListRequest): ResponseInterface
    {
        $id = $userListRequest->getId();
        $userList = UserList();
        $responseUserList = new GetUserListResponse($userList);
        return $responseUserList;
    }
}