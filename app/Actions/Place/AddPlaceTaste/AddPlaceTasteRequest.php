<?php

namespace Hedonist\Actions\Place\AddPlaceTaste;

class AddPlaceTasteRequest
{
    private $placeId;
    private $tasteId;

    public function __construct(int $placeId, int $tasteId)
    {
        $this->placeId = $placeId;
        $this->tasteId = $tasteId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getTasteId(): int
    {
        return $this->tasteId;
    }
}