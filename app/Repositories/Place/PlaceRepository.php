<?php

namespace Hedonist\Repositories\Place;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\UserList\UserList;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{

    public function model()
    {
        return Place::class;
    }

    public function save(Place $place): Place
    {
        $place->push();

        return $place;
    }

    public function getById(int $id): ?Place
    {
        return Place::with(['localization'])->where(['id' => $id])->get()->first();
    }

    public function findAll(): Collection
    {
        return Place::all();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id)
    {
        $this->delete($id);
    }

    public function getByList(int $listId)
    {
        return UserList::find($listId)->places();
    }
}