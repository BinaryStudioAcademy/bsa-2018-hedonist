<?php

namespace Hedonist\Repositories\Dislike;

use Hedonist\Entities\Dislike\Dislike;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;

interface DislikeRepositoryInterface
{
    public function save(Dislike $dislike): Dislike;

    public function getById(int $id) : ?Dislike;

    public function findAll(): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;
}