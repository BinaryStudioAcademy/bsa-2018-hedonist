<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Exceptions\UserList\UserListExistsException;
use Hedonist\Exceptions\UserList\UserListPermissionDeniedException;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class DeleteUserListImageAction
{
    private $userListRepository;

    public function __construct(UserListRepositoryInterface $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(DeleteUserListImageRequest $request): void
    {
        $userList = $this->userListRepository->getById($request->getUserListId());
        if (!$userList) {
            throw new UserListExistsException();
        }

        if (Gate::denies('deleteImg', $userList)) {
            throw new UserListPermissionDeniedException();
        }

        $userList->img_url = null;
        $this->userListRepository->save($userList);
    }
}