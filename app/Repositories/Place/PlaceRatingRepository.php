<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceRating;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\PlaceCategory;

class PlaceRatingRepository extends BaseRepository implements PlaceRatingRepositoryInterface
{
    public function model()
    {
        // TODO: Implement model() method.
    }

    public function findAll(): Collection
    {
        // TODO: Implement findAll() method.
    }

    public function getById(int $id): PlaceRating
    {
        // TODO: Implement getById() method.
    }

    public function getByPlaceUser(int $placeId, int $userId): PlaceRating
    {
        // TODO: Implement getByPlaceUser() method.
    }

    public function getAverage(int $placeId): Float
    {
        // TODO: Implement getAverage() method.
    }

    public function save(PlaceRating $placeRating): PlaceRating
    {
        // TODO: Implement save() method.
    }


}