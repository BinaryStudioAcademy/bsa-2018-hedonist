<?php

namespace Hedonist\Repositories\User;


use Hedonist\Entities\User;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface UserRepositoryInterface
{
    public function getById(int $id): ?User;

    public function findAll(): Collection;

    public function save(User $user): User;

    public function getByEmail(string $email): ?User;
}