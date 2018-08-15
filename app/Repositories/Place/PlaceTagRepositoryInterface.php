<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceTag;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlaceTagRepositoryInterface
{
    public function save(PlaceTag $placeCategoryTag): PlaceTag;

    public function findByPlace(int $placeId): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;
}
