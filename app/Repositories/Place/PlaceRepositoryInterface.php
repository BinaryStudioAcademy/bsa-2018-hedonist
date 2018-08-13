<?php

namespace Hedonist\Repositories\Place;

use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\Place;

interface PlaceRepositoryInterface
{
    public function save(Place $placeCategory): Place;

    public function getById(int $id) : ?Place;

    public function findAll(): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id);
}
