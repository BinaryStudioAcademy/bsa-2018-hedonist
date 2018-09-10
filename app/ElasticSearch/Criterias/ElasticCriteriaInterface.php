<?php

namespace Hedonist\ElasticSearch\Criterias;


use Sleimanx2\Plastic\DSL\SearchBuilder;

interface ElasticCriteriaInterface
{
    public function apply(SearchBuilder $builder): SearchBuilder;
}