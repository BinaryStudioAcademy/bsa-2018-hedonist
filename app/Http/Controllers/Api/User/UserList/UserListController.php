<?php

namespace Hedonist\Http\Controllers\Api\User\UserList;

use Hedonist\Actions\UserList\DeleteUserListAction;
use Hedonist\Actions\UserList\DeleteUserListRequest;
use Hedonist\Actions\UserList\GetUserListPresenter;
use Hedonist\Actions\UserList\GetUserListsCollectionRequest;
use Hedonist\Actions\UserList\SaveUserListRequest;
use Hedonist\Actions\UserList\SaveUserListAction;
use Hedonist\Actions\UserList\GetCollectionUserListAction;
use Hedonist\Actions\UserList\GetUserListsCollectionAction;
use Hedonist\Actions\UserList\GetUserListAction;
use Hedonist\Actions\UserList\GetUserListRequest;
use Hedonist\Exceptions\DomainException;
use Hedonist\Exceptions\UserList\UserListPermissionDeniedException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\UserList\UserListAddRequest;
use Hedonist\Http\Requests\UserList\UserListUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserListController extends ApiController
{
    public $saveUserListAction;
    public $getCollectionUserListActionOfAllUsers;
    public $getCollectionUserListsOfOneUserAction;
    public $getUserListAction;
    public $deleteUserListAction;

    public function __construct(
        SaveUserListAction $saveUserListAction,
        GetCollectionUserListAction $getCollectionUserListAction,
        GetUserListsCollectionAction $getCollectionUserListsAction,
        GetUserListAction $getUserListAction,
        DeleteUserListAction $deleteUserListAction
    ) {
        $this->saveUserListAction = $saveUserListAction;
        $this->getCollectionUserListActionOfAllUsers = $getCollectionUserListAction;
        $this->getCollectionUserListsOfOneUserAction = $getCollectionUserListsAction;
        $this->getUserListAction = $getUserListAction;
        $this->deleteUserListAction = $deleteUserListAction;
    }

    public function index()
    {
        $responseUserLists = $this->getCollectionUserListActionOfAllUsers->execute();
        return $this->successResponse($responseUserLists->toArray(), 200);
    }

    public function userLists(int $userId) : JsonResponse
    {
        $resUserLists = $this->getCollectionUserListsOfOneUserAction->execute(
            new GetUserListsCollectionRequest($userId)
        );
        return $this->successResponse($resUserLists->toArray());
    }

    public function store(UserListAddRequest $request)
    {
        try {
            $responseUserList = $this->saveUserListAction->execute(
                new SaveUserListRequest(
                    Auth::id(),
                    $request->get('name'),
                    $request->file('image'),
                    $request->get('attached_places')
                )
            );
            return $this->successResponse($responseUserList->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function show(int $id, GetUserListPresenter $presenter)
    {
        try {
            $responseUserList = $this->getUserListAction->execute(
                new GetUserListRequest($id)
            );
            return $this->successResponse($presenter->present($responseUserList), 200);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 404);
        }
    }

    public function update(UserListUpdateRequest $request, int $id)
    {
        try {
            $responseUserList = $this->saveUserListAction->execute(
                new SaveUserListRequest(
                    Auth::id(),
                    $request->get('name'),
                    $request->file('image'),
                    $request->get('attached_places'),
                    $id
                )
            );
            return $this->successResponse($responseUserList->toArray(), 201);
        } catch (UserListPermissionDeniedException | DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->deleteUserListAction->execute(new DeleteUserListRequest($id));
        } catch (UserListPermissionDeniedException | DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
