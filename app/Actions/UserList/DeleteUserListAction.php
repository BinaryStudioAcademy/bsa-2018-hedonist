<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Repositories\UserList\UserListRepositoryInterface;

class DeleteUserListAction
{
    private $userListRepository;

    public function __construct(UserListRepositoryInterface $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(DeleteUserListRequest $request): DeleteUserListResponse
    {
        $this->userListRepository->deleteById($request->getId());

        return new DeleteUserListResponse();
    }
}