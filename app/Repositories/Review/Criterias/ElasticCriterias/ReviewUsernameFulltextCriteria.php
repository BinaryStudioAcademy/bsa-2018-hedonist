<?php

namespace Hedonist\Repositories\Review\Criterias\ElasticCriterias;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ReviewUsernameFulltextCriteria implements ElasticCriteriaInterface
{
    private $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        return $builder->should()->multiMatch(['first_name','last_name'],$this->query);
    }
}