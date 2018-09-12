<?php

namespace Hedonist\Repositories\Review\Criterias\ElasticCriterias;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ReviewDefaultSortCriteria implements ElasticCriteriaInterface
{
    const DEFAULT_SORT = 'created_at';
    const DEFAULT_ORDER = 'desc';

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        return $builder->sortBy(self::DEFAULT_SORT, self::DEFAULT_ORDER);
    }
}