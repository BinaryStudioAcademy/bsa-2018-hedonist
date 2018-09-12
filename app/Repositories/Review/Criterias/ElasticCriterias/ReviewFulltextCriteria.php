<?php

namespace Hedonist\Repositories\Review\Criterias\ElasticCriterias;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ReviewFulltextCriteria implements ElasticCriteriaInterface
{
    private $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        return $builder->multiMatch(
            ['user.first_name','user.last_name','description'],
            $this->query,
            ['fuzziness' => 'AUTO']
        );
    }
}