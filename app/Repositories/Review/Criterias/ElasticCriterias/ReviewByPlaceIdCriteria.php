<?php

namespace Hedonist\Repositories\Review\Criterias\ElasticCriterias;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ReviewByPlaceIdCriteria implements ElasticCriteriaInterface
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        $builder->filter()->term('place_id',$this->id);
        return $builder;
    }
}