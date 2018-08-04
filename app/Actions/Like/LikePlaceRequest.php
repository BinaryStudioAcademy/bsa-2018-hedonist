<?php

namespace Hedonist\Actions\Like;

class LikePlaceRequest
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