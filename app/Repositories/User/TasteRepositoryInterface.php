<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\CustomTaste;
use Hedonist\Entities\User\Taste;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface TasteRepositoryInterface
{
    public function getById(int $id): ?Taste;

    public function findAll(): Collection;

    public function save(Taste $taste): Taste;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function findByUser(int $userId): Collection;

    public function deleteById(int $id): void;
}