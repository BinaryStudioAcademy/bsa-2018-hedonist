<?php
namespace Hedonist\Repositories\Review\Criterias\ElasticCriterias;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ElasticReviewByIdCriteria implements ElasticCriteriaInterface
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        return $builder->filter()->term('id', $this->id);
    }
}