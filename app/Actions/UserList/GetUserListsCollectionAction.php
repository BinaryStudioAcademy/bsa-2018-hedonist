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

    public function execute(GetUserListsCollectionRequest $request): GetUserListsCollectionResponse
    {
        return new GetUserListsCollectionResponse(
            $this->userListsRepository->findUserListsWithPlaces($request->getUserId())
        );
    }
}