<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\UserInfo;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface UserInfoRepositoryInterface extends RepositoryInterface
{
    public function getById(int $id): ?UserInfo;

    public function findAll(): Collection;

    public function save(UserInfo $user): UserInfo;

    public function getByUserId(int $user_id): ?UserInfo;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;
}