<?php

namespace Hedonist\Repositories\PlaceList;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Hedonist\Entities\PlaceList\UserList;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PlaceListRepositoryEloquent.
 *
 * @package namespace App\Repositories\PlaceList;
 */
class UserListRepository extends BaseRepository implements UserListRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save(UserList $userList): UserList 
    {
        $userList->save();
        
        return $userList;
    }
    /**
     * {@inheritdoc}
     */
    public function getById(int $id): UserList
    {
        return UserList::findOrFail($id);
    }
    /**
     * {@inheritdoc}
     */
    public function findAll(): Collection 
    {
        return UserList::all();
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
        UserList::destroy($id);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserList::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
