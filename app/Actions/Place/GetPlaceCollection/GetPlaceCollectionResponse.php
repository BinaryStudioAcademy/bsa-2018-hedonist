<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Illuminate\Database\Eloquent\Collection;

class GetPlaceCollectionResponse
{
    private $placeCollection;
    private $userId;
    private $reviews;

    public function __construct(Collection $places,Collection $reviews,int $userId)
    {
        $this->placeCollection = $places;
        $this->userId = $userId;
        $this->reviews = $reviews;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->placeCollection;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }
}
