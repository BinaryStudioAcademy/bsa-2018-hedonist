<?php
namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\Checkin;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class CheckinRepository extends BaseRepository implements CheckinRepositoryInterface
{
    public function model()
    {
        return Checkin::class;
    }

    public function save(Checkin $placesVisited): Checkin
    {
        $placesVisited->save();

        return $placesVisited;
    }

    public function findAll(): Collection
    {
        return Checkin::all();
    }

    public function getById(int $id): ?Checkin
    {
        return Checkin::find($id);
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