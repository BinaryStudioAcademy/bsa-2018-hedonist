<?php

namespace Hedonist\Actions\UserList;

class SaveUserListAction
{
    public function execute(SaveUserListRequest $userListRequest): SaveUserListResponse
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