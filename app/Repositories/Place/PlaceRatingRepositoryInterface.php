<?php

namespace Hedonist\Repositories\Place;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\PlaceRating;

interface PlaceRatingRepositoryInterface
{
    public function findAll(): Collection;

    public function getById(int $id) : PlaceRating;

    public function getByPlaceUser(int $placeId, int $userId) : PlaceRating;

    public function getAverage(int $placeId) : Float;

    public function save(PlaceRating $placeRating) : PlaceRating;

}