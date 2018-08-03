<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;

class SaveUserListAction implements ActionInterface
{
    public function execute(RequestInterface $userListRequest): ResponseInterface
    {
        $id = $userListRequest->getId();
        if (!$id) {
            $userList = new UserList;
        } else {
            $userList = UserList::find($id);
        }

        $userList->user_id = $userListRequest->getUserId();
        $userList->name = $userListRequest->getName();
        $userList->img_url = $userListRequest->getImgUrl();
        $responseRepository = new SaveUserListResponse($userList);
        return $responseRepository;
    }
}