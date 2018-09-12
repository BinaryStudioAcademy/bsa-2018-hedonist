<?php

namespace Hedonist\ElasticSearch\Repositories;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Illuminate\Support\Collection;

abstract class AbstractElasticRepository implements ElasticRepositoryInterface
{
    private $criterias = [];

    abstract protected function model(): string;

    public function get(): Collection
    {
        $query = $this->model()::search();
        foreach ($this->criterias as $criteria) {
            $query = $criteria->apply($query);
        }
        return $query->get()->hits();
    }

    final public function pushCriteria(ElasticCriteriaInterface $criteria): ElasticRepositoryInterface
    {
        $this->criterias[] = $criteria;

        return $this;
    }

    final public function clearCriterias(): ElasticRepositoryInterface
    {
        $this->criterias = [];

        return $this;
    }
}