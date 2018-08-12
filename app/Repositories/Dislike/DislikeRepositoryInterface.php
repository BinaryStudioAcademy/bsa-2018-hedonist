<?php

namespace Hedonist\Repositories\Dislike;

use Hedonist\Entities\Dislike\Dislike;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;

interface DislikeRepositoryInterface
{
    public function save(Dislike $dislike): Dislike;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function findByUserAndPlace(int $userId, int $placeId): ?Dislike;

    public function deleteById(int $id): void;
}