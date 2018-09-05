<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;
use Hedonist\Exceptions\UserList\UserListPermissionDeniedException;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Hedonist\Services\FileNameGenerator;
use Hedonist\Services\TransactionServiceInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SaveUserListAction
{
    private $userListRepository;
    private $transactionService;

    const FILE_STORAGE = 'upload/photo/';

    public function __construct(
        UserListRepositoryInterface $userListRepository,
        TransactionServiceInterface $transactionService
    ) {
        $this->userListRepository = $userListRepository;
        $this->transactionService = $transactionService;
    }

    public function execute(SaveUserListRequest $userListRequest): SaveUserListResponse
    {
        return $this->transactionService->run(
            function () use ($userListRequest) {
                $id = $userListRequest->getId();
                if (!$id) {
                    $userList = new UserList;
                } else {
                    $userList = $this->userListRepository->getById($id);
                    if (Gate::denies('update', $userList)) {
                        throw new UserListPermissionDeniedException;
                    }
                }

                $file = $userListRequest->getImage();

                if ($file !== null) {
                    $imageName = (new FileNameGenerator($file))->generateFileName();
                    Storage::disk()->putFileAs(self::FILE_STORAGE, $file, $imageName, 'public');
                    $userList->img_url = Storage::disk()->url(self::FILE_STORAGE . $imageName);
                }
                $userList->user_id = $userListRequest->getUserId();
                $userList->name = $userListRequest->getName() ?? $userList->name;

                $userList = $this->userListRepository->save($userList);
                if ($userListRequest->getAttachedPlaces() !== null) {
                    $this->userListRepository
                        ->syncPlaces($userList, $userListRequest->getAttachedPlaces());
                }

                if ($userListRequest->getAttachedPlaces() === null) {
                    $this->userListRepository
                        ->syncPlaces($userList, []);
                }

                if (is_null($id)) {
                    Log::info("User list {$userList->id} is added");
                } else {
                    Log::info("User list {$userList->id} is updated");
                }
                return new SaveUserListResponse($userList);
            });
    }
}