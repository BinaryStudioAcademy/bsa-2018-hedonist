<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceCategoryTag;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlaceCategoryTagRepositoryInterface
{
    public function save(PlaceCategoryTag $placeCategoryTag): PlaceCategoryTag;
 
    public function findAll(): Collection;
    
    public function getById(int $id): ?PlaceCategoryTag;

    public function findByCategory(int $categoryId): Collection;
     
    public function findByCriteria(CriteriaInterface $criteria): Collection;
    
    public function deleteById(int $id): void;
}
