<?php

namespace Hedonist\Repositories\Review;

use Hedonist\ElasticSearch\Criterias\Common\ElasticByIdCriteria;
use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Hedonist\ElasticSearch\Repositories\AbstractElasticRepository;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Collection;

class ElasticReviewRepository extends AbstractElasticRepository implements ElasticReviewRepositoryInterface
{

    protected function model(): string
    {
        return Review::class;
    }

    public function findAll(): Collection
    {
        return $this->get();
    }

    public function getById(int $id): ?Review
    {
        return $this->pushCriteria(new ElasticByIdCriteria($id))->get()->first();
    }

    public function findCollectionByCriterias(ElasticCriteriaInterface ...$criterias): Collection
    {
        foreach ($criterias as $criteria){
            $this->pushCriteria($criteria);
        }
        $result = $this->get();
        $this->clearCriterias();

        return $result;
    }
}