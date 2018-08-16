<?php

namespace Hedonist\Actions\Place\Checkin;

use Illuminate\Database\Eloquent\Collection;

class GetUserCheckInCollectionResponse
{
    private $checkIns;

    public function __construct(Collection $checkIns)
    {
        $this->checkIns = $checkIns;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->checkIns;
    }
}