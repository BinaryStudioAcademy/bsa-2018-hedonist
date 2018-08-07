<?php

namespace Hedonist\Actions\Dislike;

class DislikePlaceRequest
{
    private $placeId;

    public function __construct(int $placeId)
    {
        $this->placeId = $placeId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }
}