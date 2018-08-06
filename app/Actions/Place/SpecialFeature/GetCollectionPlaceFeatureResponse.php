<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class GetCollectionPlaceFeatureResponse
{
    protected $collection;

    /**
     * GetCollectionPlaceFeatureResponse constructor.
     * @param array $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

}