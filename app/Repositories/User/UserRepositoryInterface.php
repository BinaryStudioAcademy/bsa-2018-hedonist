<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\Taste;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getById(int $id): ?User;

    public function findAll(): Collection;

    public function save(User $user): User;

    public function getByEmail(string $email): ?User;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;

    public function addTaste(User $user, Taste $taste): void;

    public function deleteTaste(User $user, Taste $taste): void;

    public function setTastes(User $user, Collection $tastes): void;

    public function getUserBySocialAuthCredentials(string $provider, string $token): ?User;
}