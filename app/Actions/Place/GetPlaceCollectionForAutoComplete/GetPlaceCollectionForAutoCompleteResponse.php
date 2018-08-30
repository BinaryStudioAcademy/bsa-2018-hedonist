<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete;

use Illuminate\Database\Eloquent\Collection;

class GetPlaceCollectionForAutoCompleteResponse
{
    private $placeCollection;

    public function __construct(Collection $places)
    {
        $this->placeCollection = $places;
    }

    public function getPlaceCollection(): Collection
    {
        return $this->placeCollection;
    }
}