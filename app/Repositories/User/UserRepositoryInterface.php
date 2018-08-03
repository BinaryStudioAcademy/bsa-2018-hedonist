<?php

namespace Hedonist\Repositories\User;


use Hedonist\Entities\User;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getById(int $id): ?User;

    public function findAll(): Collection;

    public function save(User $user): User;

    public function getByEmail(string $email): ?User;

    public function findByCriteria(CriteriaInterface $criteria):Collection;

    public function addPasswordResetLink(string $email):string;

    //fatal error if delete(int $id)
    public function delete($id): void;
}