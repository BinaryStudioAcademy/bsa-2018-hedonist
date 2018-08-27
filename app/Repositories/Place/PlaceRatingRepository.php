<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceRating;
use Hedonist\Entities\Place\RatingAverage;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;

class PlaceRatingRepository extends BaseRepository implements PlaceRatingRepositoryInterface
{
    public function model()
    {
        return PlaceRating::class;
    }
  
    public function save(PlaceRating $placeRating): PlaceRating
    {
        $placeRating->save();
        
        return $placeRating;
    }
    
    public function findAll(): Collection
    {
        return PlaceRating::all();
    }
    
    public function getById(int $id): ?PlaceRating
    {
        return PlaceRating::find($id);
    }
    
    public function findByCriteria(CriteriaInterface $criteria)
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        PlaceRating::destroy($id);
    }

    public function getByPlaceUser(int $placeId, int $userId): ?PlaceRating
    {
        return PlaceRating::where('user_id', $userId)
            ->where('place_id', $placeId)
            ->first();
    }

    public function getAverage(int $placeId): ?float
    {
        return PlaceRating::where('place_id', $placeId)
            ->avg('rating');
    }

    public function getVotesCount(int $placeId): ?int
    {
        return PlaceRating::where('place_id', $placeId)
            ->count();
    }

    public function getAvgByPlaceIds(array $ids): Collection
    {
        $collection = new Collection();

        $queryRating = PlaceRating::selectRaw('AVG(rating) as rating, place_id')
            ->whereIn('place_id', $ids)
            ->groupBy('place_id')
            ->get();
        foreach ($queryRating as $rating) {
            $collection->push(new RatingAverage($rating->place_id, $rating->rating));
        }

        return $collection;
    }
}
