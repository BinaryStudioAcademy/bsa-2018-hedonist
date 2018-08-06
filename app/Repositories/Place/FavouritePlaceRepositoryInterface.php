<?php

namespace Hedonist\Repositories\Place;

use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\FavouritePlace;

interface FavouritePlaceRepositoryInterface
{
    public function save(FavouritePlace $placeCategory): FavouritePlace;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id);
}
