<?php

namespace Hedonist\Repositories\Place;

use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\PlaceCategory;

interface PlaceCategoryRepositoryInterface
{
    public function save(PlaceCategory $placeCategory): PlaceCategory;
 
    public function getById(int $id) : ?PlaceCategory;
    
    public function findAll(): Collection;
     
    public function findByCriteria(CriteriaInterface $criteria): Collection;
    
    public function delete(int $id);
}