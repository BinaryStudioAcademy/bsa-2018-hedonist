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

    public function execute(DeleteUserListRequest $request)
    {
        $this->userListRepository->deleteById($request->getId());
    }
}