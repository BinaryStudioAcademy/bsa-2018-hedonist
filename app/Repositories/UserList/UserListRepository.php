<?php

namespace Hedonist\Repositories\PlaceList;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Hedonist\Entities\PlaceList\UserList;
use Illuminate\Database\Eloquent\Collection;

class UserListRepository extends BaseRepository implements UserListRepositoryInterface
{
     
    public function save(UserList $userList): UserList 
    {
        $userList->save();
        
        return $userList;
    }
    
    public function getById(int $id): ?UserList
    {
        return UserList::find($id);
    }
    
    public function findAll(): Collection 
    {
        return UserList::all();
    }
     
    public function findByCriteria(CriteriaInterface $criteria): Collection 
    {
        return $this->getByCriteria($criteria);
    }
    
    public function deleteById(int $id) 
    {
        $this->delete($id);
    }
    
    public function model()
    {
        return UserList::class;
    }
    
}
