<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Exceptions\UserList\UserListExistsException;
use Hedonist\Exceptions\UserList\UserListPermissionDeniedException;
use Hedonist\Notifications\FollowedUserDeleteListNotification;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteUserListAction
{
    private $userListRepository;
    private $userRepository;

    public function __construct(
        UserListRepositoryInterface $userListRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->userListRepository = $userListRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(DeleteUserListRequest $request): DeleteUserListResponse
    {
        $userList = $this->userListRepository->getById($request->getId());
        if (is_null($userList)) {
            throw new UserListExistsException('User list not found.');
        }

        if (Gate::denies('delete', $userList)) {
            throw new UserListPermissionDeniedException;
        }

        $this->userListRepository->deleteById($request->getId());

        $user = Auth::user();
        Log::info("user_list: User {$user->id} delete user list {$userList->id}");
        $this->sendNotificationToFollowers(
            new FollowedUserDeleteListNotification($userList, Auth::user())
        );

        return new DeleteUserListResponse();
    }

    private function sendNotificationToFollowers(Notification $notification): void
    {
        foreach ($this->userRepository->getFollowers(Auth::user()) as $user) {
            if ((bool) $user->info->notifications_receive === true) {
                $user->notify($notification);
            }
        }
    }
}