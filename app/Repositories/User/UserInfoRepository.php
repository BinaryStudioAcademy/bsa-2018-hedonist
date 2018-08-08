<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\UserInfo;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class UserInfoRepository extends BaseRepository implements UserInfoRepositoryInterface
{

    public function model()
    {
        return UserInfo::class;
    }

    public function getById(int $id): ?UserInfo
    {
        return UserInfo::find($id);
    }

    public function findAll(): Collection
    {
        return UserInfo::all();
    }

    public function save(UserInfo $userInfo): UserInfo
    {
        $userInfo->push();

        return $userInfo;
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function getByUserId(int $user_id): ?UserInfo
    {
        return UserInfo::where(["user_id" => $user_id])->first();
    }

    public function deleteById(int $id): void
    {
        $this->delete($id);
    }

}