<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceTaste;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

class PlaceTasteRepository implements PlaceTasteRepositoryInterface
{
    public function save(PlaceTaste $placeTaste): PlaceTaste
    {
        $placeTaste->save();

        return $placeTaste;
    }

    public function getById(int $id): ?PlaceTaste
    {
        return PlaceTaste::find($id);
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        PlaceTaste::destroy($id);
    }

    public function getByPlace(int $placeId): Collection
    {
        return PlaceTaste::where('place_id', $placeId)->get();
    }

    public function getByTaste(int $tasteId): Collection
    {
        return PlaceTaste::where('taste_id', $tasteId)->get();
    }

    public function getByPlaceAndTaste(int $placeId, int $tasteId): ?PlaceTaste
    {
        return PlaceTaste::where('place_id', $placeId)->where('taste_id', $tasteId)->first();
    }

    public function model()
    {
        return PlaceTaste::class;
    }
}