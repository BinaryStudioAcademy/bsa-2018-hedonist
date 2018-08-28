<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\Tag;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface TagRepositoryInterface
{
    public function save(Tag $tag): Tag;
 
    public function findAll(): Collection;
    
    public function getById(int $id): ?Tag;

    public function findByCategory(int $categoryId): Collection;
     
    public function findByCriteria(CriteriaInterface $criteria): Collection;
    
    public function deleteById(int $id): void;
}
