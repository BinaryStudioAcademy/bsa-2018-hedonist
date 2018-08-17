<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\Location;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\UserList\UserList;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{
    public function model()
    {
        return Place::class;
    }

    public function save(Place $place): Place
    {
        $place->push();

        return $place;
    }

    public function getById(int $id): ?Place
    {
        return Place::with(['localization'])->where(['id' => $id])->get()->first();
    }

    public function findAll(): Collection
    {
        return Place::all();
    }

    public function getAllWithRelations(): Collection
    {
        return Place::with(
            'category',
            'category.tags',
            'city',
            'localization',
            'localization.language',
            'likes',
            'dislikes',
            'ratings',
            'reviews')
            ->get();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function findByCoordinates(Location $center, float $radius): Collection
    {
        $places = Place::select('*', DB::raw(
            '( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance'))
            ->having('distance', '<=', $radius)
            ->setBindings([$center->getLatitude(), $center->getLongitude(), $center->getLatitude()])
            ->get();

        return $places;
    }

    public function deleteById(int $id)
    {
        $this->delete($id);
    }

    public function getByList(int $listId)
    {
        return UserList::find($listId)->places();
    }
}