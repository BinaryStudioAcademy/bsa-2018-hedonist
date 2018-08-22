<?php

namespace Hedonist\Repositories\UserList;

use Hedonist\Entities\Place\Place;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\UserList\UserList;

interface UserListRepositoryInterface
{
    public function save(UserList $userList): UserList;

    public function getById(int $id): ?UserList;

    public function findAll(): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function attachPlace(UserList $list, Place $place): void;

    public function deleteById(int $id): void;
}
