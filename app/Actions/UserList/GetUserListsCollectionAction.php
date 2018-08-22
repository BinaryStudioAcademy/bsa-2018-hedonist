<?php
namespace Hedonist\Actions\UserList;

use Hedonist\Repositories\UserList\UserListRepositoryInterface;

class GetUserListsCollectionAction
{
    private $userListsRepository;

    public function __construct(UserListRepositoryInterface $userListsRepository)
    {
        $this->userListsRepository = $userListsRepository;
    }

    public function execute(GetUserListsCollectionRequest $request): GetUserListsCollectionResponse
    {
        $userId = $request->getUserId();
        return new GetUserListsCollectionResponse(
            $this->userListsRepository->findUserListsWithPlaces($userId)
        );
    }
}