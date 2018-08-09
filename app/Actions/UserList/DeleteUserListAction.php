<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Repositories\UserList\UserListRepository;

class DeleteUserListAction
{
    private $userListRepository;

    public function __construct(UserListRepository $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(DeleteUserListRequest $request): DeleteUserListResponse
    {
        $this->userListRepository->deleteById($request->getId());

        return new DeleteUserListResponse();
    }
}