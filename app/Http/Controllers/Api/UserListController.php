<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Request\UserList\UserListRequest;
use Hedonist\Services\UserList\UserListServiceInterface;
use Illuminate\Http\Request;
use Hedonist\Http\Controllers\Controller;

class UserListController extends Controller
{
    public $userListService;

    public function __construct(UserListServiceInterface $userListService)
    {
        $this->userListService = $userListService;
    }

    public function index()
    {
        $data = $this->userListService->getCollection();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $userListRequest = new UserListRequest(
            $request->get('user_id'),
            $request->get('name'),
            $request->get('img_url')
        );
        try {
            $userList = $this->userListService->save($userListRequest);
            return response()->json($userList, 201);
        } catch( \Exception $exception) {
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
            $userList = $this->userListService->getUserList($id);
            $data = [
                'id' => $userList->id,
                'name' => $userList->name,
                'user_id' => $userList->user_id,
                'img_url' => $userList->imgUrl,
            ];
            return response()->json($data, 200);
        } catch( \Exception $exception) {
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
        $userListRequest = new UserListRequest(
            $request->get('user_id'),
            $request->get('name'),
            $request->get('img_url')
        );
        try {
            $userList = $this->userListService->save($userListRequest, $id);
            return response()->json($userList, 201);
        } catch( \Exception $exception) {
            $error = [
                'error' => [
                    'message' => $exception->getMessage(),
                    'status_code' => 400,
                ]
            ];
            return response()->json($error, 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userListService->getUserList($id)->delete();
            return response()->json(['success'], 201);
        } catch( \Exception $exception) {
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
