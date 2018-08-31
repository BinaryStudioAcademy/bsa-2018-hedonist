<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Hedonist\Services\FileNameGenerator;
use Hedonist\Services\TransactionServiceInterface;
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
                }

                $file = $userListRequest->getImage();
                if($file){
                    $imageName = (new FileNameGenerator($file))->generateFileName();
                    Storage::disk()->putFileAs(self::FILE_STORAGE, $file, $imageName, 'public');
                    $userList->img_url = Storage::disk()->url(self::FILE_STORAGE . $imageName);
                } else {
                    $userList->img_url = null;
                }
                $userList->user_id = $userListRequest->getUserId();
                $userList->name = $userListRequest->getName();

                $userList = $this->userListRepository->save($userList);
                if ($userListRequest->getAttachedPlaces() !== null) {
                    $this->userListRepository
                        ->syncPlaces($userList, $userListRequest->getAttachedPlaces());
                }

                return new SaveUserListResponse($userList);
            });
    }
}