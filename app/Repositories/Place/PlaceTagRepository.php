<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceTag;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CriteriaInterface;

class PlaceTagRepository extends BaseRepository implements PlaceTagRepositoryInterface
{
    public function model()
    {
        return PlaceTag::class;
    }

    public function save(PlaceTag $placeTag): PlaceTag
    {
        $placeTag->save();

        return $placeTag;
    }

    public function findByPlace(int $placeId): Collection
    {
        return PlaceTag::place($placeId)->get();
    }

    public function findByCriteria(CriteriaInterface $criteria)
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        PlaceTag::destroy($id);
    }
}
