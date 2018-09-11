<?php

namespace Hedonist\ElasticSearch\Repositories;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Illuminate\Support\Collection;

abstract class AbstractElasticRepository implements ElasticRepositoryInterface
{
    private $criterias = [];

    protected abstract function model(): string;

    public function get(): Collection
    {
        $query = $this->model()::search();
        foreach ($this->criterias as $criteria) {
            $query = $criteria->apply($query);
        }
        return $query->get()->hits();
    }

    public final function pushCriteria(ElasticCriteriaInterface $criteria): ElasticRepositoryInterface
    {
        $this->criterias[] = $criteria;

        return $this;
    }

    public function clearCriterias(): ElasticRepositoryInterface
    {
        $this->criterias = [];

        return $this;
    }
}