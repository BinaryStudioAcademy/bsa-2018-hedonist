<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Repositories\UserList\UserListRepositoryInterface;

class GetCollectionUserListAction
{
    private $userListRepository;

    public function __construct(UserListRepositoryInterface $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(): GetCollectionUserListResponse
    {
        $userLists = $this->userListRepository->findAll();

        return new GetCollectionUserListResponse($userLists);
    }
}