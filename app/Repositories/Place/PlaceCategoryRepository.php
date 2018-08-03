<?php

namespace Hedonist\Repositories\Place;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\PlaceCategory;

class PlaceCategoryRepository extends BaseRepository implements PlaceCategoryRepositoryInterface
{
    public function save(PlaceCategory $placeCategory): PlaceCategory 
    {
        $placeCategory->save();
        
        return $placeCategory;
    }
    
    public function getById(int $id): PlaceCategory
    {
        return PlaceCategory::find($id);
    }
    
    public function findAll(): Collection 
    {
        return PlaceCategory::all();
    }
    
    public function findByCriteria(CriteriaInterface $criteria): Collection 
    {
        return $this->getByCriteria($criteria);
    }
    
    public function delete(int $id) 
    {
        PlaceCategory::destroy($id);
    }
    
    public function model()
    {
        return PlaceCategory::class;
    }
    
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}