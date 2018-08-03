<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\ResponseInterface;

class CollectionSpecialFeatureResponse implements ResponseInterface
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