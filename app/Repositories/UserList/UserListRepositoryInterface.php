<?php

namespace Hedonist\Repositories\UserList;

use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\PlaceList\UserList;

/**
 * Interface PlaceListRepository.
 *
 * @package namespace App\Repositories\PlaceList;
 */
interface UserListRepositoryInterface
{
    /**
     * @param \Hedonist\Entities\PlaceList\UserList $userList
     *
     * @return \Hedonist\Entities\PlaceList\UserList
    */
    public function save(UserList $userList): UserList;
    /**
     * Get place list by id
     *
     @param int $id
     *
     * @return \Hedonist\Entities\PlaceList\UserList
     */
    public function getById(int $id) : UserList;
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
