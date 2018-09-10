<?php

namespace Hedonist\Repositories\Review\Criterias\ElasticCriterias;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\AggregationBuilder;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ReviewPopularSortCriteria implements ElasticCriteriaInterface
{
    const POPULAR_SORT = 'likes_count';
    const POPULAR_ORDER = 'desc';

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        $builder->aggregate(function(AggregationBuilder $builder){
            $builder->valueCount(self::POPULAR_SORT, 'likes');
            return $builder;
        });
        $builder->sortBy(self::POPULAR_SORT,self::POPULAR_ORDER);
        return $builder;
    }
}