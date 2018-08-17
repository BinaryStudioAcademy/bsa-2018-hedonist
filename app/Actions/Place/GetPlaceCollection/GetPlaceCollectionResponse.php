<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Illuminate\Database\Eloquent\Collection;

class GetPlaceCollectionResponse
{
    private $placeCollection;
    private $userId;

    public function __construct(Collection $places,int $userId)
    {
        $this->placeCollection = $places;
        $this->userId = $userId;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->placeCollection;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
