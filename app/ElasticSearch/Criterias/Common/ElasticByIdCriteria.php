<?php
namespace Hedonist\ElasticSearch\Criterias\Common;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ElasticByIdCriteria implements ElasticCriteriaInterface
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