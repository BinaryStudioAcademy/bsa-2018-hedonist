<?php

namespace Hedonist\Actions\Place\GetPlaceCategoryItem;

use Hedonist\Entities\Place\PlaceCategory;

class GetPlaceCategoryItemResponse
{
    private $placeCategory;

    public function __construct(PlaceCategory $placeCategory)
    {
        $this->placeCategory = $placeCategory;
    }

    public function getModel(): PlaceCategory
    {
        return $this->placeCategory;
    }

    public function toArray(): array
    {
        return $this->placeCategory->toArray();
    }
}