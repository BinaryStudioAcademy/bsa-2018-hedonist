<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlacePhoto;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class PlacePhotoRepository extends BaseRepository implements PlacePhotoRepositoryInterface
{
    public function save(PlacePhoto $placePhoto): PlacePhoto
    {
        $placePhoto->save();
        return $placePhoto;
    }

    public function getById(int $id): ?PlacePhoto
    {
        return PlacePhoto::find($id);
    }

    public function findAll(): Collection
    {
        return PlacePhoto::all();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        $this->delete($id);
    }

    public function model()
    {
        return PlacePhoto::class;
    }

    public function getByPlace(int $placeId): Collection
    {
        return PlacePhoto::place($placeId)->get();
    }
}