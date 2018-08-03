<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceFeature;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlaceFeatureRepositoryInterface extends RepositoryInterface
{
    public function save(PlaceFeature $placeFeature): PlaceFeature;
 
    public function findAll(): Collection;
    
    public function getById(int $id): ?PlaceFeature;
     
    public function findByCriteria(CriteriaInterface $criteria);
    
    public function delete(int $id): void;
}
