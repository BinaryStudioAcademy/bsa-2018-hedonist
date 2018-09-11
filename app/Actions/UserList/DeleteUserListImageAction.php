<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Exceptions\UserList\UserListExistsException;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;

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
        $userList->img_url = '';
        $this->userListRepository->save($userList);
    }
}