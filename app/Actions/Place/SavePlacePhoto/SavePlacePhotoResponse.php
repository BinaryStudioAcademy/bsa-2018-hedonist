<?php

namespace Hedonist\Actions\Place\SavePlacePhoto;

use Hedonist\Entities\Place\PlacePhoto;

class SavePlacePhotoResponse
{
    private $placePhoto;

    public function __construct(PlacePhoto $placePhoto)
    {
        $this->placePhoto = $placePhoto;
    }

    public function getModel(): PlacePhoto
    {
        return $this->placePhoto;
    }

    public function toArray(): array
    {
        return $this->placePhoto->toArray();
    }
}