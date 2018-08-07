<?php

namespace Hedonist\Repositories\UserTaste;

use Hedonist\Entities\User\Taste;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class TasteRepository extends BaseRepository implements TasteRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Taste::class;
    }

    public function getById(int $id): ?Taste
    {
        return Taste::find($id);
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
}