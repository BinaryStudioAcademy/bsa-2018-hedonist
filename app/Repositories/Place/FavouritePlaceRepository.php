<?php
namespace Hedonist\Repositories\Place;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\FavouritePlace;

class FavouritePlaceRepository extends BaseRepository implements FavouritePlaceRepositoryInterface
{

    public function model()
    {
        return FavouritePlace::class;
    }

    public function save(FavouritePlace $favPlace): FavouritePlace
    {
        $favPlace->push();

        return $favPlace;
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id)
    {
        FavouritePlace::destroy($id);
    }
}