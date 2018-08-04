<?php

namespace Hedonist\Repositories\Like;

use Hedonist\Entities\Like;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;

interface LikeRepositoryInterface
{
    public function save(Like $like): Like;

    public function getById(int $id) : ?Like;

    public function findAll(): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;
}