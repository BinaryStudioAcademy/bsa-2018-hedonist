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

    public function findUserLists(int $userId) : Collection;

    public function findUserListsWithPlaces(int $userId) : Collection;

    public function findAll(): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id);

    public function model();

    public function attachPlace(UserList $userList, Place $place);
}
