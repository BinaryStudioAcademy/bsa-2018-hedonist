<?php

namespace Hedonist\Actions\Place\GetPlaceCategoryCollection;

use Illuminate\Database\Eloquent\Collection;

class GetPlaceCategoryCollectionResponse
{
    private $placeCategoryCollection;

    public function __construct(Collection $placeCategoryCollection)
    {
        $this->placeCategoryCollection = $placeCategoryCollection;
    }

    public function getCollection(): Collection
    {
        return $this->placeCategoryCollection;
    }

    public function toArray(): array
    {
        return $this->placeCategoryCollection->toArray();
    }
}