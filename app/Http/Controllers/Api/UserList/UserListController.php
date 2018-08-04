<?php

namespace Hedonist\Http\Controllers\Api\UserList;

use Hedonist\Actions\UserList\DeleteUserListAction;
use Hedonist\Actions\UserList\DeleteUserListRequest;
use Hedonist\Actions\UserList\SaveUserListRequest;
use Hedonist\Actions\UserList\SaveUserListAction;
use Hedonist\Actions\UserList\GetCollectionUserListAction;
use Hedonist\Actions\UserList\GetUserListAction;
use Hedonist\Actions\UserList\GetUserListRequest;
use Illuminate\Http\Request;
use Hedonist\Http\Controllers\Controller;

class UserListController extends Controller
{
    public $userListAction;
    public $collectionUserListAction;
    public $getUserListAction;
    public $deleteUserListAction;

    public function __construct(SaveUserListAction $userListAction,
                                GetCollectionUserListAction $collectionUserListAction,
                                GetUserListAction $getUserListAction,
                                DeleteUserListAction $deleteUserListAction)
    {
        $this->userListAction = $userListAction;
        $this->collectionUserListAction = $collectionUserListAction;
        $this->getUserListAction = $getUserListAction;
        $this->deleteUserListAction = $deleteUserListAction;
    }

    public function index()
    {
        $data = $this->collectionUserListAction->execute();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        try {
            $responseUserList = $this->userListAction->execute(
                new SaveUserListRequest(
                    null,
                    $request->get('user_id'),
                    $request->get('name'),
                    $request->get('img_url')
                )
            );
            return response()->json($responseUserList->getModel(), 201);
        } catch (\Exception $exception) {
            $error = [
                'error' => [
                    'message' => $exception->getMessage(),
                    'status_code' => 400,
                ]
            ];
            return response()->json($error, 400);
        }
    }

    public function show(int $id)
    {
        try {
            $responseUserList = $this->getUserListAction->execute(
                new GetUserListRequest($id)
            );
            return response()->json($responseUserList->getData(), 200);
        } catch (\Exception $exception) {
            $error = [
                'error' => [
                    'message' => $exception->getMessage(),
                    'status_code' => 400,
                ]
            ];
            return response()->json($error, 400);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $responseUserList = $this->userListAction->execute(
                new SaveUserListRequest(
                    $id,
                    $request->get('user_id'),
                    $request->get('name'),
                    $request->get('img_url')
                )
            );
            return response()->json($responseUserList->getModel(), 201);
        } catch (\Exception $exception) {
            $error = [
                'error' => [
                    'message' => $exception->getMessage(),
                    'status_code' => 400,
                ]
            ];
            return response()->json($error, 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $responseDeleteUser = $this->deleteUserListAction->execute(new DeleteUserListRequest($id));
            return response()->json($responseDeleteUser->result(), 200);
        } catch (\Exception $exception) {
            $error = [
                'error' => [
                    'message' => $exception->getMessage(),
                    'status_code' => 400,
                ]
            ];
            return response()->json($error, 400);
        }
    }
}
