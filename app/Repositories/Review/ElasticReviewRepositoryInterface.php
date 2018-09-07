<?php

namespace Hedonist\Repositories\Review;

use Hedonist\Entities\Review\Review;
use Illuminate\Support\Collection;

interface ElasticReviewRepositoryInterface
{
    public function findAll(): Collection;

    public function getById(int $id): ?Review;

    public function save(Review $review): Review;

    public function deleteById(int $id): void;

    //public function findCollectionByCriterias(CriteriaInterface ...$criterias): Collection;

    public function getTotalCountByPlace(int $placeId): int;
}