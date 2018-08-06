<?php

namespace Hedonist\Repositories\UserTaste;


use Hedonist\Entities\User\UserTaste;
use Illuminate\Support\Collection;

interface UserTasteRepositoryInterface
{
    public function getById(int $id): ?UserTaste;

    public function findAll(): Collection;

    public function save(UserTaste $taste): UserTaste;

    public function deleteById(int $id): void;
}