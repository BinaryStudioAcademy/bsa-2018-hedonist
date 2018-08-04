<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    const RESET_LINK_EXPIRE_HOURS = 24;

    public function getById(int $id): User
    {
        return User::find($id);
    }

    public function findAll(): Collection
    {
        return User::all();
    }


    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function getByEmail(string $email): ?User
    {
        return User::where(["email" => $email])->first();
    }

    public function deleteById(int $id): void
    {
        User::destroy($id);
    }

    public function model()
    {
        return User::class;
    }
}