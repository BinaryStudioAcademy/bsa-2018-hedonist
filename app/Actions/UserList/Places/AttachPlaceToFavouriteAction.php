<?php

namespace Hedonist\Actions\UserList\Places;

use Hedonist\Entities\UserList\FavouriteList;
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\UserList\UserListNotFoundException;
use Hedonist\Exceptions\NonAuthorizedException;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AttachPlaceToFavouriteAction
{
    private $userListRepository;
    private $placeRepository;

    public function __construct(
        UserListRepositoryInterface $userListRepository,
        PlaceRepositoryInterface $placeRepository
    ) {
        $this->userListRepository = $userListRepository;
        $this->placeRepository = $placeRepository;
    }

    public function execute(AttachPlaceToFavouriteRequest $request): void
    {
        $place = $this->placeRepository->getById($request->getPlaceId());
        if (!$place) {
            throw new PlaceNotFoundException();
        }
        $list = $this->userListRepository->getFavouriteListByUser(Auth::id());
        if (empty($list)) {
            $list = new FavouriteList([
                'is_default' => true,
                'user_id' => Auth::id(),
                'name' => FavouriteList::FAVOURITE_LIST_NAME
            ]);
            $list->save();
        }
        $placeToAttach = $this->placeRepository
            ->getByList($list->id)
            ->find($place->id);
        if (empty($placeToAttach)) {
            $this->userListRepository->attachPlaceToFavourite($list, $place);
        }
    }
}
