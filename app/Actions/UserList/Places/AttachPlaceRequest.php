<?php

namespace Hedonist\Actions\UserList\Places;

class AttachPlaceRequest
{
    private $userListId;
    private $placeId;

    public function __construct(int $userListId, int $placeId)
    {
        $this->userListId = $userListId;
        $this->placeId = $placeId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getUserListId(): int
    {
        return $this->userListId;
    }
}
