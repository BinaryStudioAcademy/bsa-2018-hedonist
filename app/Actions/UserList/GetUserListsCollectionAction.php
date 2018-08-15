<?php
namespace Hedonist\Actions\UserList;

use Hedonist\Repositories\UserList\UserListRepository;

class GetUserListsCollectionAction
{
    private $userListsRepository;

    public function __construct(UserListRepository $userListsRepository)
    {
        $this->userListsRepository = $userListsRepository;
    }

    public function execute(int $userId): GetCollectionUserListsResponse
    {
        $userLists = $this->userListsRepository->findUserLists($userId);
        return new GetCollectionUserListsResponse($userLists);
    }
}