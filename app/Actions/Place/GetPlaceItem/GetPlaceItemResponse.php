<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Entities\Place\Place;

class GetPlaceItemResponse
{
    private $place;
    private $userId;

    public function __construct(Place $place, int $userId)
    {
        $this->place = $place;
        $this->userId = $userId;
    }

    public function getPlace(): Place
    {
        return $this->place;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
