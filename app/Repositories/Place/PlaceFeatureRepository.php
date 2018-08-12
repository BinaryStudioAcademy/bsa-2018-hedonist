<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceFeature;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CriteriaInterface;

class PlaceFeatureRepository extends BaseRepository implements PlaceFeatureRepositoryInterface
{
    public function model()
    {
        return PlaceFeature::class;
    }

    public function save(PlaceFeature $placeFeature): PlaceFeature
    {
        $placeFeature->save();

        return $placeFeature;
    }

    public function findAll(): Collection
    {
        return PlaceFeature::all();
    }

    public function getById(int $id): ?PlaceFeature
    {
        return PlaceFeature::find($id);
    }

    public function findByCriteria(CriteriaInterface $criteria)
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        PlaceFeature::destroy($id);
    }
}
