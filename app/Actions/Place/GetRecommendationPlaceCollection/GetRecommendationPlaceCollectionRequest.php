<?php

namespace Hedonist\Actions\Place\GetRecommendationPlaceCollection;

class GetRecommendationPlaceCollectionRequest
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}