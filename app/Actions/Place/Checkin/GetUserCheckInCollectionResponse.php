<?php

namespace Hedonist\Actions\Place\Checkin;

use Illuminate\Database\Eloquent\Collection;

class GetUserCheckInCollectionResponse
{
    private $checkIns;
    private $ratings;

    public function __construct(Collection $checkIns, Collection $ratings)
    {
        $this->checkIns = $checkIns;
        $this->ratings = $ratings;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->checkIns;
    }

    public function getRatingCollection(): Collection
    {
        return $this->ratings;
    }
}