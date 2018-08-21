<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;

class GetPlaceItemResponse
{
    private $place;
    private $user;

    public function __construct(Place $place, User $user)
    {
        $this->place = $place;
        $this->user = $user;
    }

    public function getPlace(): Place
    {
        return $this->place;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
