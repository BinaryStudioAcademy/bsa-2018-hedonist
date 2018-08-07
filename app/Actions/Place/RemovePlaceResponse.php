<?php

namespace Hedonist\Actions\Place;


use Illuminate\Database\Eloquent\Collection;

class GetPlaceCollectionResponse
{
    private $placeCollection;

    public function __construct(Collection $places)
    {
        $this->placeCollection = $places;
    }

    /**
     * Gets PlaceCollection.
     *
     * @return Collection
     */
    public function getPlaceCollection(): Collection
    {
        return $this->placeCollection;
    }
}
