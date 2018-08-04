<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;

class GetCollectionUserListResponse
{
    private $collectionUserList;

    public function __construct(UserList $collectionUserList)
    {
        $this->collectionUserList = $collectionUserList;
    }

    public function getCollection()
    {
        return $this->collectionUserList;
    }

    public function getData()
    {
        return $this->collectionUserList->toArray();
    }
}