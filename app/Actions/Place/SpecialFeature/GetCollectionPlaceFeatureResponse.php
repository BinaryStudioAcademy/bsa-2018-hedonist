<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class GetCollectionPlaceFeatureResponse
{
    protected $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function getCollection(): array
    {
        return $this->collection;
    }
}