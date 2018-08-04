<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class CollectionSpecialFeatureResponse
{
    /** @var ReadSpecialFeatureResponse[] */
    protected $collection;

    /**
     * CollectionSpecialFeatureResponse constructor.
     * @param ReadSpecialFeatureResponse[] $collection
     */
    public function __construct(array $collection)
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