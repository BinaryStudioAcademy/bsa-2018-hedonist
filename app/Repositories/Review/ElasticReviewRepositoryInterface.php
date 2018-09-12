<?php

namespace Hedonist\Repositories\Review;

use Hedonist\ElasticSearch\Criterias\ElasticCriteriaInterface;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Collection;

interface ElasticReviewRepositoryInterface
{
    public function findAll(): Collection;

    public function getById(int $id): ?Review;

    public function findCollectionByCriterias(ElasticCriteriaInterface ...$criterias): Collection;
}