<?php

namespace Hedonist\Actions\UserList\Places;

class DetachPlaceRequest
{
    private $placeId;
    private $listId;

    public function __construct(int $placeId, int $listId)
    {
        $this->placeId = $placeId;
        $this->listId = $listId;
    }

    public function getListId(): int
    {
        return $this->listId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }
}