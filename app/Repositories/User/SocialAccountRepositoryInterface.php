<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\SocialAccount;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface SocialAccountRepositoryInterface
{
    public function getById(int $id): ?SocialAccount;

    public function findAll(): Collection;

    public function save(SocialAccount $account): SocialAccount;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;

    public function findByUser(int $userId): Collection;
}