<?php
namespace Hedonist\Actions\UserList;

use Hedonist\Repositories\UserList\UserListRepository;
use Illuminate\Support\Facades\Auth;

class GetUserListsCollectionAction
{
    private $userListsRepository;

    public function __construct(UserListRepository $userListsRepository)
    {
        $this->userListsRepository = $userListsRepository;
    }

    public function execute(GetUserListsCollectionRequest $request): GetUserListsCollectionResponse
    {
        $userId = $request->getUserId();
        $userId = $userId?: Auth::id();
        return new GetUserListsCollectionResponse(
            $this->userListsRepository->findUserListsWithPlaces($userId)
        );
    }
}