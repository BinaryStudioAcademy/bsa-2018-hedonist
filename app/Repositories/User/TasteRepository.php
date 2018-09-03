<?php

namespace Hedonist\Repositories\User;

use Hedonist\Entities\User\CustomTaste;
use Hedonist\Entities\User\Taste;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class TasteRepository extends BaseRepository implements TasteRepositoryInterface
{
    public function model()
    {
        return Taste::class;
    }

    public function getById(int $id): ?Taste
    {
        return Taste::find($id);
    }

    public function getByName(string $name): ?Taste
    {
        return Taste::where('name', $name)->first();
    }

    public function findAll(): Collection
    {
        return Taste::all();
    }

    public function save(Taste $taste): Taste
    {
        $taste->save();

        return $taste;
    }

    public function deleteById(int $id): void
    {
        Taste::destroy($id);
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function findByUser(int $userId): Collection
    {
        return Taste::whereHas(
            'users',
            function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            }
        )->get();
    }
}