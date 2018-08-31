<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceTaste;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlaceTasteRepositoryInterface
{
    public function save(PlaceTaste $placeTaste): PlaceTaste;

    public function getById(int $id) : ?PlaceTaste;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id): void;

    public function getByPlace(int $placeId): Collection;

    public function getByTaste(int $tasteId): Collection;

    public function getByPlaceAndTaste(int $placeId, int $tasteId): ?PlaceTaste;
}