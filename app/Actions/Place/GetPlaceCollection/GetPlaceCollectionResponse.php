<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Database\Eloquent\Collection;

class GetPlaceCollectionResponse
{
    private $placeCollection;
    private $amount;
    private $user;

    public function __construct(Collection $places, User $user, ?int $amount = null)
    {
        $this->placeCollection = $places;
        $this->amount = $amount;
        $this->user = $user;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->placeCollection;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
