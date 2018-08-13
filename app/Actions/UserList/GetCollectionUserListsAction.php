<?php
namespace Hedonist\Actions\UserList;


use Hedonist\Repositories\UserList\UserListRepository;

class GetCollectionUserListsAction
{
    private $userListsRepository;

    public function __construct(UserListRepository $userListsRepository)
    {
        $this->userListsRepository = $userListsRepository;
    }

    public function execute(int $user_id): GetCollectionUserListsResponse
    {
        $userLists = $this->userListsRepository->findUserLists($user_id);
        return new GetCollectionUserListsResponse($userLists);
    }
}