<?php

namespace Hedonist\ElasticSearch\Criterias\Common;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Sleimanx2\Plastic\DSL\SearchBuilder;

class ElasticPaginationCriteria implements ElasticCriteriaInterface
{
    const LIMIT = 10;
    private $page;
    private $limit;

    public function __construct(int $page, ?int $limit = null)
    {
        $this->page = $page;
        $this->limit = $limit ?? self::LIMIT;
    }

    public function apply(SearchBuilder $builder): SearchBuilder
    {
        return $builder->from(($this->page - 1) * $this->limit)->size($this->limit);
    }
}