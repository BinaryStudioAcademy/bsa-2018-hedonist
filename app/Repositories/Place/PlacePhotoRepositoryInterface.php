<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlacePhoto;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlacePhotoRepositoryInterface
{
    public function save(PlacePhoto $placePhoto): PlacePhoto;

    public function getById(int $id) : ?PlacePhoto;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;

    public function getByPlace(int $placeId): Collection;
}