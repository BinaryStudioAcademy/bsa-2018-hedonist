<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Entities\User\User;
use Illuminate\Database\Eloquent\Collection;

class GetPlaceCollectionResponse
{
    private $placeCollection;
    private $user;
    private $reviews;

    public function __construct(Collection $places, Collection $reviews, User $user)
    {
        $this->placeCollection = $places;
        $this->user = $user;
        $this->reviews = $reviews;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->placeCollection;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }
}
