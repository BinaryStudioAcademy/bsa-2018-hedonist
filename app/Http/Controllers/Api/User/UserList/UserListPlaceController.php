<?php

namespace Hedonist\Http\Controllers\Api\User\UserList;

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\UserList\Places\{AttachPlaceAction,
    AttachPlaceRequest,
    AttachPlaceToFavouriteAction,
    AttachPlaceToFavouriteRequest,
    DetachPlaceAction,
    DetachPlaceRequest};
use Hedonist\Http\Requests\UserList\AttachPlaceHttpRequest;
use Hedonist\Http\Requests\UserList\DetachPlaceHttpRequest;
use Hedonist\Repositories\UserList\UserListRepository;
use Illuminate\Http\JsonResponse;
use Hedonist\Exceptions\DomainException;
use Illuminate\Http\Request;

class UserListPlaceController extends ApiController
{
    public $attachPlaceAction;
    private $attachPlaceToFavouriteAction;
    private $userListRepository;

    public function __construct(
        AttachPlaceAction $attachPlaceAction,
        AttachPlaceToFavouriteAction $attachPlaceToFavouriteAction,
        UserListRepository $userListRepository
    ) {
        $this->attachPlaceAction = $attachPlaceAction;
        $this->attachPlaceToFavouriteAction = $attachPlaceToFavouriteAction;
        $this->userListRepository = $userListRepository;
    }

    public function attachPlace(int $listId, AttachPlaceHttpRequest $httpRequest): JsonResponse
    {
        try {
            $this->attachPlaceAction->execute(
                new AttachPlaceRequest($listId, $httpRequest->id)
            );
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
        return $this->emptyResponse(201);
    }

    public function attachPlaceToFavourite(Request $request): JsonResponse
    {
        try {
            $this->attachPlaceToFavouriteAction->execute(
                new AttachPlaceToFavouriteRequest($request->input('id'))
            );
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
        return $this->emptyResponse(201);
    }

    public function detachPlace(int $listId, DetachPlaceHttpRequest $request, DetachPlaceAction $action): JsonResponse
    {
        try {
           $action->execute(
                new DetachPlaceRequest($listId, $request->placeId)
            );
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
        return $this->emptyResponse(201);
    }
}
