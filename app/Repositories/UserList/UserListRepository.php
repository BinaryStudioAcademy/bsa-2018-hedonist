<?php

namespace Hedonist\Repositories\UserList;

use Hedonist\Entities\UserList\FavouriteList;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Hedonist\Entities\UserList\UserList;
use Hedonist\Entities\Place\Place;
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

    public function getFavouriteListByUser(int $userId): ?FavouriteList
    {
        return FavouriteList::where('user_id', $userId)->first();
    }

    public function findUserLists(int $userId): Collection
    {
        return UserList::where('user_id', $userId)->get();
    }

    public function findUserListsWithPlaces(int $userId): Collection
    {
        return UserList::with('places', 'places.tags', 'places.photos')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function findAll(): Collection
    {
        return UserList::all();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id): void
    {
        $userList = $this->getById($id);
        $userList->places()->detach();
        $this->delete($id);
    }

    public function model()
    {
        return UserList::class;
    }

    public function attachPlace(UserList $list, Place $place): void
    {
        $list->places()->attach($place->id);
    }

    public function detachPlace(UserList $list, Place $place): void
    {
        $list->places()->detach($place->id);
    }

    public function attachPlaceToFavourite(FavouriteList $list, Place $place): void
    {
        $list->places()->attach($place->id);
    }


    public function findCollectionByCriterias(CriteriaInterface ...$criterias): Collection
    {
        foreach ($criterias as $criteria) {
            $this->pushCriteria($criteria);
        }
        $result = $this->all();
        $this->resetCriteria();

        return $result;
    }

    public function syncPlaces(UserList $list, array $placeIds): void
    {
        $list->places()->sync($placeIds);
    }
}
