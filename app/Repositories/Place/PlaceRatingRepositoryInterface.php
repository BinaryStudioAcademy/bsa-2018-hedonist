<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceRating;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlaceRatingRepositoryInterface
{
    public function save(PlaceRating $placeRating): PlaceRating;
 
    public function findAll(): Collection;
    
    public function getById(int $id): ?PlaceRating;
     
    public function findByCriteria(CriteriaInterface $criteria);
    
    public function deleteById(int $id): void;

    public function getByPlaceUser(int $placeId, int $userId) : PlaceRating;

    public function getAverage(int $placeId) : Float;

}
