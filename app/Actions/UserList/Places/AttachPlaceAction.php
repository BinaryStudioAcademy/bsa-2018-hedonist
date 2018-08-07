<?php

namespace Hedonist\Actions\UserList\Places;

use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\NonAuthorizedException;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AttachPlaceAction
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

    public function execute(AttachPlaceRequest $request): AttachPlaceResponse
    {
        $userList = $this->userListRepository->getById($request->getUserListId());
        if ($userList->user_id !== Auth::id()) {
            throw new NonAuthorizedException();
        }
        $place = $this->placeRepository->getById($request->getPlaceId());
        if (empty($place)) {
            throw new PlaceNotFoundException();
        }
        if (empty($userListPlace)) {  // userListPlaceRepository?..
            $userListPlace = new UserListPlace([
                'list_id' => $request->getUserListId(),
                'place_id' => $request->getPlaceId()
            ]);
            //$this->likeRepository->save($like);
        }
        return new AttachPlaceResponse();
    }
}
