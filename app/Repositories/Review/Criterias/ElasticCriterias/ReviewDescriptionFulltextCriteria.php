<?php

namespace Hedonist\Repositories\Review\Criterias\ElasticCriterias;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ReviewDescriptionFulltextCriteria implements ElasticCriteriaInterface
{
    private $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        return $builder->match('text',$this->query);
    }
}