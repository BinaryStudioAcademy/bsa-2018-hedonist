<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Repositories\UserList\UserListRepository;

class GetCollectionUserListAction
{
    private $userListRepository;

    public function __construct(UserListRepository $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(): GetCollectionUserListResponse
    {
        $userLists = $this->userListRepository->findAll();
        return new GetCollectionUserListResponse($userLists);
    }
}