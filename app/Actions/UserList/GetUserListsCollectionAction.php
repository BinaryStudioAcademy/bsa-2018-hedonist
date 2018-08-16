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

    public function execute(GetUserListsCollectionRequest $userId): GetUserListsCollectionResponse
    {
        $userLists = $this->userListsRepository->findUserLists($userId->getUserId());
        return new GetUserListsCollectionResponse($userLists);
    }
}