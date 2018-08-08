<?php
namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceCheckin;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class PlaceCheckinRepository extends BaseRepository implements PlaceCheckinRepositoryInterface
{
    public function model()
    {
        return PlaceCheckin::class;
    }

    public function save(PlaceCheckin $placesVisited): PlaceCheckin
    {
        $placesVisited->save();

        return $placesVisited;
    }

    public function findAll(): Collection
    {
        return PlaceCheckin::all();
    }

    public function getById(int $id): ?PlaceCheckin
    {
        return PlaceCheckin::find($id);
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