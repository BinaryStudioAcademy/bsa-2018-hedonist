<?php

namespace Hedonist\Repositories\Place;


use Hedonist\Entities\Place\PlacesVisited;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class PlacesVisitedRepository extends BaseRepository implements PlacesVisitedRepositoryInterface
{
    public function model()
    {
        return PlacesVisited::class;
    }

    public function save(PlacesVisited $placesVisited): PlacesVisited
    {
        $placesVisited->save();

        return $placesVisited;
    }

    public function findAll(): Collection
    {
        return PlacesVisited::all();
    }

    public function getById(int $id): ?PlacesVisited
    {
        return PlacesVisited::find($id);
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id)
    {
        $this->delete($id);
    }

}