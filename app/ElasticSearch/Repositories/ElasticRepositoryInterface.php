<?php

namespace Hedonist\ElasticSearch\Repositories;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Illuminate\Support\Collection;

interface ElasticRepositoryInterface
{
    public function get(): Collection;

    public function pushCriteria(ElasticCriteriaInterface $criteria): self;

    public function clearCriterias(): self;
}