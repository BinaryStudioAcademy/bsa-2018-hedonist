<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Exceptions\UserList\UserListExistsException;
use Hedonist\Exceptions\UserList\UserListPermissionDeniedException;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteUserListAction
{
    private $userListRepository;

    public function __construct(UserListRepositoryInterface $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(DeleteUserListRequest $request): DeleteUserListResponse
    {
        $userList = $this->userListRepository->getById($request->getId());
        if (is_null($userList)) {
            throw new UserListExistsException('User list not found.');
        }

        if (Gate::denies('delete', $userList)) {
            throw new UserListPermissionDeniedException;
        }

        $this->userListRepository->deleteById($request->getId());

        $user = Auth::user();
        Log::info("user_list: User {$user->id} delete user list {$userList->id}");
        return new DeleteUserListResponse();
    }
}