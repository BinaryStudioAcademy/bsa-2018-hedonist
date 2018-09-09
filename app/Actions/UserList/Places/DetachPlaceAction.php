<?php

namespace Hedonist\Actions\UserList\Places;


use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\UserList\UserListNotFoundException;
use Hedonist\Exceptions\UserList\UserListPermissionDeniedException;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class DetachPlaceAction
{
    private $listRepository;
    private $placeRepository;

    public function __construct(
        UserListRepositoryInterface $listRepository,
        PlaceRepositoryInterface $placeRepository
    ) {
        $this->listRepository = $listRepository;
        $this->placeRepository = $placeRepository;
    }

    public function execute(DetachPlaceRequest $request): void
    {
        $list = $this->listRepository->getById($request->getListId());
        if (is_null($list)) {
            throw new UserListNotFoundException();
        }
        if (Gate::denies('userList.detachPlace', $list)) {
            throw new UserListPermissionDeniedException();
        }
        $place = $this->placeRepository->getById($request->getPlaceId());
        if (is_null($place)) {
            throw new PlaceNotFoundException();
        }
        $this->listRepository->detachPlace($list, $place);
    }
}