<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;
use Hedonist\Exceptions\UserList\UserListPermissionDeniedException;
use Hedonist\Notifications\FollowedUserAddListNotification;
use Hedonist\Notifications\FollowedUserUpdateListNotification;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Hedonist\Services\FileNameGenerator;
use Hedonist\Services\TransactionServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SaveUserListAction
{
    private $userListRepository;
    private $transactionService;
    private $userRepository;
    private $placeRepository;

    const FILE_STORAGE = 'upload/photo/';

    public function __construct(
        UserListRepositoryInterface $userListRepository,
        TransactionServiceInterface $transactionService,
        UserRepositoryInterface $userRepository,
        PlaceRepositoryInterface $placeRepository
    ) {
        $this->userListRepository = $userListRepository;
        $this->transactionService = $transactionService;
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;
    }

    public function execute(SaveUserListRequest $userListRequest): SaveUserListResponse
    {
        return $this->transactionService->run(
            function () use ($userListRequest) {
                $id = $userListRequest->getId();
                $attachedPlacesIds = $userListRequest->getAttachedPlaces() ?? [];
                $detachedPlaces = collect();
                $attachedPlaces = collect();
                if (!$id) {
                    $userList = new UserList;
                } else {
                    $userList = $this->userListRepository->getById($id);
                    if (Gate::denies('update', $userList)) {
                        throw new UserListPermissionDeniedException;
                    }

                    list($detachedPlaces, $attachedPlaces) = $this
                        ->getDetachedAndAttachedPlaces($userList->places, $attachedPlacesIds);
                }

                $file = $userListRequest->getImage();
                if ($file !== null) {
                    $imageName = (new FileNameGenerator($file))->generateFileName();
                    Storage::disk()->putFileAs(self::FILE_STORAGE, $file, $imageName, 'public');
                    $userList->img_url = Storage::disk()->url(self::FILE_STORAGE . $imageName);
                }

                $userList->user_id = $userListRequest->getUserId();
                if (!$userList->is_default) {
                    $userList->name = $userListRequest->getName() ?? $userList->name;
                }

                $userList = $this->userListRepository->save($userList);
                $this->userListRepository
                    ->syncPlaces($userList, $attachedPlacesIds);

                $user = Auth::user();
                if (is_null($id)) {
                    Log::info("user_list: User {$user->id} added user list {$userList->id}");
                    $this->sendNotificationToFollowers(
                        new FollowedUserAddListNotification($userList, $user)
                    );
                } else {
                    Log::info("user_list: User {$user->id} updated user list {$userList->id}");
                    $this->sendNotificationToFollowers(new FollowedUserUpdateListNotification(
                            $userList, $detachedPlaces, $attachedPlaces, $user)
                    );
                }

                return new SaveUserListResponse($userList);
            });
    }

    private function sendNotificationToFollowers(Notification $notification): void
    {
        foreach ($this->userRepository->getFollowers(Auth::user()) as $user) {
            if ((bool) $user->info->notifications_receive === true) {
                $user->notify($notification);
            }
        }
    }

    private function getDetachedAndAttachedPlaces(Collection $places, array $attachedPlacesIds): array
    {
        $detachedPlaces = $places->filter(function ($place) use (&$attachedPlacesIds) {
            $key = array_search($place->id, $attachedPlacesIds);
            if ($key === false) {
                return true;
            }

            unset($attachedPlacesIds[$key]);
            return false;
        });

        return [
            $detachedPlaces,
            $this->placeRepository->getGeneralInfoByIds($attachedPlacesIds)
        ];
    }
}