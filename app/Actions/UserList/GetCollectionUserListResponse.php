<?php

namespace Hedonist\Actions\UserList;

class GetCollectionUserListResponse
{
    private $collectionUserList;

    public function __construct($collectionUserList)
    {
        $this->collectionUserList = $collectionUserList;
    }

    public function getCollection()
    {
        return $this->collectionUserList;
    }

    public function getData()
    {
        return $this->collectionUserList->all();
    }
}