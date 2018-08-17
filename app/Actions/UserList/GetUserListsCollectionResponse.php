<?php
namespace Hedonist\Actions\UserList;

use Illuminate\Database\Eloquent\Collection;

class GetUserListsCollectionResponse
{
    private $collectionUserLists;

    public function __construct(Collection $collectionUserLists)
    {
        $this->collectionUserLists = $collectionUserLists;
    }

    public function getCollection(): Collection
    {
        return $this->collectionUserLists;
    }

    public function toArray(): array
    {
        return $this->collectionUserLists->toArray();
    }
}