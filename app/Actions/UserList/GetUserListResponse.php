<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;

class GetUserListResponse
{
    private $userList;

    public function __construct(UserList $userList)
    {
        $this->userList = $userList;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->userList->id,
            'name' => $this->userList->name,
            'user_id' => $this->userList->user_id,
            'img_url' => $this->userList->img_url,
        ];
    }
}