<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Exceptions\UserList\UserListExistsException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByUserListCriteria;
use Hedonist\Repositories\Place\Criterias\PlaceGetLastReviewByUserCriteria;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetUserListAction
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

    public function execute(GetUserListRequest $userListRequest): GetUserListResponse
    {
        $id = $userListRequest->getId();
        $userList = $this->userListRepository->getById($id);
        clock($userList);
        if (is_null($userList)) {
            throw new UserListExistsException('User list not found.');
        }
        $places = $this->placeRepository->findCollectionByCriterias(
            new PlaceGetLastReviewByUserCriteria(Auth::id()),
            new GetPlaceByUserListCriteria($id),
            new AllPlacePhotosCriteria()
        );

        return new GetUserListResponse($userList, $places, Auth::user());
    }
}