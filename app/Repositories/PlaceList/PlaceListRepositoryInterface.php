<?php

namespace Hedonist\Repositories\Entities\PlaceList;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\PlaceList\PlaceList;

/**
 * Interface PlaceListRepository.
 *
 * @package namespace App\Repositories\PlaceList;
 */
interface PlaceListRepositoryInterface
{
    /**
     * @param \Hedonist\Entities\PlaceList\PlaceList $placeList
     *
     * @return \Hedonist\Entities\PlaceList\PlaceList
    */
    public function save(PlaceList $placeList): PlaceList;
    /**
     * Get place list by id
     *
     @param int $id
     *
     * @return \Hedonist\Entities\PlaceList\PlaceList
     */
    public function getById(int $id) : PlaceList;
    /**
     * Get all placelists
     * 
     * @return Collection
     */
    public function findAll(): Collection;
     /**
     * Find data by Criteria
     *
     * @param CriteriaInterface $criteria
     *
     * @return mixed
     */
    public function findByCriteria(CriteriaInterface $criteria);
    /**
     * Delete PlaceList
     * 
     * @return void
     */
    public function delete($id);
}
