<?php

namespace Hedonist\Repositories\Place;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Hedonist\Entities\Localization\Language;
use Hedonist\Entities\Place\Checkin;
use Hedonist\Entities\Place\Location;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\UserList\UserList;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{
    const EARTH_RADIUS_IN_KM = 6371;

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

    public function getByIdWithRelations(int $id): ?Place
    {
        return Place::with(
            [
                'category',
                'tags',
                'city',
                'localization',
                'localization.language',
                'likes',
                'dislikes',
                'ratings',
                'worktime'
            ]
        )
            ->where(['id' => $id])
            ->first();
    }

    public function findAll(): Collection
    {
        return Place::all();
    }

    public function getAllWithRelations(): Collection
    {
        return Place::with(
            'category',
            'tags',
            'city',
            'localization',
            'localization.language',
            'likes',
            'photos',
            'dislikes',
            'ratings',
            'worktime'
        )->get();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function findByCoordinates(Location $center, float $radius): Collection
    {
        $places = Place::select('*', DB::raw(
            '( ? * acos( cos( radians(?) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin(radians(latitude)) ) ) AS distance'))
            ->having('distance', '<=', $radius)
            ->setBindings([self::EARTH_RADIUS_IN_KM, $center->getLatitude(), $center->getLongitude(), $center->getLatitude()])
            ->get();

        return $places;
    }

    public function deleteById(int $id): void
    {
        $this->delete($id);
    }

    public function getByList(int $listId): Collection
    {
        return UserList::find($listId)->places()->get();
    }

    public function findCollectionByCriterias(CriteriaInterface ...$criterias): Collection
    {
        foreach ($criterias as $criteria) {
            $this->pushCriteria($criteria);
        }
        $result = $this->all();
        $this->resetCriteria();

        return $result;
    }

    public function setTranslations(Place $place, array $localizations): void
    {
        foreach ($localizations as $key => $value) {
            $place->localization()->create([
               'place_name'        => $value['name'],
               'place_description' => $value['description'],
               'place_id'          => $place->id,
               'language_id'       => Language::where('code', $key)->first()->id
            ]);
        }
    }

    public function syncTags(Place $place, array $tags): void
    {
        $place->tags()->sync($tags);
    }

    public function syncFeatures(Place $place, array $features): void
    {
        $place->features()->sync($features);
    }

    public function setWorktime(Place $place, array $worktime): void
    {
        foreach ($worktime as $key => $value) {
            $place->worktime()->create([
                'place_id' => $place->id,
                'day_code' => $key,
                'start_time' => Carbon::parse($value['start'])->toDateTimeString(),
                'end_time' => Carbon::parse($value['end'])->toDateTimeString()
            ]);
        }
    }

    public function getPlaceCheckinsCountByUser(int $placeId, int $userId) : int
    {
        return Checkin::places($placeId)->users($userId)->count();
    }

    public function findCountByCriterias(CriteriaInterface ...$criterias): int
    {
        foreach ($criterias as $criteria) {
            $this->pushCriteria($criteria);
        }
        $result = $this->all();
        $this->resetCriteria();

        return $result->count();
    }
}