<?php

namespace Hedonist\Actions\UserList;

class GetUserListResponse
{
    private $userList;

    public function __construct($userList)
    {
        $this->userList = $userList;
    }

    public function getData()
    {
        return [
            'id' => $this->userList->id,
            'name' => $this->userList->name,
            'user_id' => $this->userList->user_id,
            'img_url' => $this->userList->imgUrl,
        ];
    }
}