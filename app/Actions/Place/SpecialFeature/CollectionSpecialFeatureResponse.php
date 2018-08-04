<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class CollectionSpecialFeatureResponse
{
    protected $collection;

    /**
     * CollectionSpecialFeatureResponse constructor.
     * @param $collection
     */
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return ReadSpecialFeatureResponse[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

}