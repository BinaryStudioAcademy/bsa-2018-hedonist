<?php

namespace Hedonist\Repositories\PlaceList;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Hedonist\Repositories\Entities\PlaceList\PlaceListRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Hedonist\Entities\PlaceList\PlaceList;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PlaceListRepositoryEloquent.
 *
 * @package namespace App\Repositories\PlaceList;
 */
class PlaceListRepository extends BaseRepository implements PlaceListRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(PlaceList $placeList): PlaceList 
    {
        $placeList->save();
        
        return $placeList;
    }
    /**
     * {@inheritdoc}
     */
    public function getById(int $id): PlaceList
    {
        return PlaceList::findOrFail($id);
    }
    /**
     * {@inheritdoc}
     */
    public function findAll(): Collection 
    {
        return PlaceList::all();
    }
    /**
     * {@inheritdoc}
     */
    public function findByCriteria(CriteriaInterface $criteria) 
    {
        
    }
    /**
     * {@inheritdoc}
     */
    public function delete($id) 
    {
        PlaceList::destroy($id);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlaceList::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
