<?php

namespace Hedonist\Repositories\UserTaste;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserTaste;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class UserTasteRepository extends BaseRepository implements UserTasteRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserTaste::class;
    }

    public function getById(int $id): ?UserTaste
    {
        return UserTaste::find($id);
    }

    public function findAll(): Collection
    {
        return UserTaste::all();
    }

    public function save(UserTaste $taste): UserTaste
    {
        $taste->save();

        return $taste;
    }

    public function deleteById(int $id): void
    {
        UserTaste::destroy($id);
    }
}