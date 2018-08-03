<?php

namespace Hedonist\Actions\Like;

use Hedonist\Actions\RequestInterface;

class LikePlaceRequest implements RequestInterface
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