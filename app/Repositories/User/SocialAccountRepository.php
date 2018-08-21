<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\SocialAccount;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class SocialAccountRepository extends BaseRepository implements SocialAccountRepositoryInterface
{
    public function model()
    {
        return SocialAccount::class;
    }

    public function getById(int $id): ?SocialAccount
    {
        return SocialAccount::find($id);
    }

    public function findAll(): Collection
    {
        return SocialAccount::all();
    }

    public function save(SocialAccount $account): SocialAccount
    {
        $account->save();

        return $account;
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        SocialAccount::destroy($id);
    }

    public function findByUser(int $userId): Collection
    {
        return SocialAccount::where('user_id', $userId)->get();
    }
}