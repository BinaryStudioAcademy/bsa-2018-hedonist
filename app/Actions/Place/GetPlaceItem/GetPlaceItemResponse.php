<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;

class GetPlaceItemResponse
{
    private $place;
    private $user;
    private $checkinsCount;

    public function __construct(Place $place, User $user, int $checkinsCount)
    {
        $this->place = $place;
        $this->user = $user;
        $this->checkinsCount = $checkinsCount;
    }

    public function getPlace(): Place
    {
        return $this->place;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCheckinsCount(): int
    {
        return $this->checkinsCount;
    }
}
