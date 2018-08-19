<?php

namespace Hedonist\Repositories\Place;

use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\PlaceCategoryTag;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CriteriaInterface;

class PlaceCategoryTagRepository extends BaseRepository implements PlaceCategoryTagRepositoryInterface
{
    public function model()
    {
        return PlaceCategoryTag::class;
    }
  
    public function save(PlaceCategoryTag $placeCategoryTag): PlaceCategoryTag
    {
        $placeCategoryTag->save();
        
        return $placeCategoryTag;
    }
    
    public function findAll(): Collection
    {
        return PlaceCategoryTag::all();
    }
    
    public function getById(int $id): ?PlaceCategoryTag
    {
        return PlaceCategoryTag::find($id);
    }

    public function findByCategory(int $categoryId): Collection
    {
        return PlaceCategoryTag::whereHas('categories', function ($query) use ($categoryId) {
                $query->where('place_category_id', $categoryId);
        })->get();
    }
    
    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }
    
    public function deleteById(int $id): void
    {
        PlaceCategoryTag::destroy($id);
    }
}
