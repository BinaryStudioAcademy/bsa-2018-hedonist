<?php

namespace Hedonist\Repositories\Review;

use Hedonist\Entities\Review\Review;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface ReviewRepositoryInterface
{
    public function findAll(): Collection;

    public function getById(int $id): ?Review;

    public function save(Review $review): Review;

    public function deleteById(int $id): void;

    public function findByCriteria(CriteriaInterface $criteria): Collection;
}
