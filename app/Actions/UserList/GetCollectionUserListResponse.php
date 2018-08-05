<?php

namespace Hedonist\Actions\UserList;

use Illuminate\Database\Eloquent\Collection;

class GetCollectionUserListResponse
{
    private $collectionUserList;

    public function __construct(Collection $collectionUserList)
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