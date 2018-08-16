<?php

namespace Hedonist\Http\Controllers\Api\User\UserList;

use Hedonist\Actions\UserList\DeleteUserListAction;
use Hedonist\Actions\UserList\DeleteUserListRequest;
use Hedonist\Actions\UserList\GetUserListsCollectionAction;
use Hedonist\Actions\UserList\SaveUserListRequest;
use Hedonist\Actions\UserList\SaveUserListAction;
use Hedonist\Actions\UserList\GetCollectionUserListAction;
use Hedonist\Actions\UserList\GetUserListAction;
use Hedonist\Actions\UserList\GetUserListRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\UserList\UserListRequest;

class UserListController extends ApiController
{
    public $userListAction;
    public $collectionUserListAction;
    public $collectionUserListsAction;
    public $getUserListAction;
    public $deleteUserListAction;

    public function __construct(
        SaveUserListAction $userListAction,
        GetCollectionUserListAction $collectionUserListAction,
        GetUserListsCollectionAction $collectionUserListsAction,
        GetUserListAction $getUserListAction,
        DeleteUserListAction $deleteUserListAction
    ) {
        $this->userListAction = $userListAction;
        $this->collectionUserListAction = $collectionUserListAction;
        $this->collectionUserListsAction = $collectionUserListsAction;
        $this->getUserListAction = $getUserListAction;
        $this->deleteUserListAction = $deleteUserListAction;
    }

    public function index()
    {
        $responseUserLists = $this->collectionUserListAction->execute();
        return $this->successResponse($responseUserLists->toArray(), 200);
    }

    public function userLists(int $userId)
    {
        $resUserLists = $this->collectionUserListsAction->execute($userId);
        return $this->successResponse($resUserLists->toArray(), 200);
    }

    public function store(UserListRequest $request)
    {
        try {
            $responseUserList = $this->userListAction->execute(
                new SaveUserListRequest(
                    $request->get('user_id'),
                    $request->get('name'),
                    $request->get('img_url')
                )
            );
            return $this->successResponse($responseUserList->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function show(int $id)
    {
        try {
            $responseUserList = $this->getUserListAction->execute(
                new GetUserListRequest($id)
            );
            return $this->successResponse($responseUserList->toArray(), 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 404);
        }
    }

    public function update(UserListRequest $request, int $id)
    {
        try {
            $responseUserList = $this->userListAction->execute(
                new SaveUserListRequest(
                    $request->get('user_id'),
                    $request->get('name'),
                    $request->get('img_url'),
                    $id
                )
            );
            return $this->successResponse($responseUserList->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->deleteUserListAction->execute(new DeleteUserListRequest($id));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
