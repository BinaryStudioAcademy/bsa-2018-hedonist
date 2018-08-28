<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\UserList\UserList;
use Hedonist\Repositories\UserList\UserListRepositoryInterface;
use Hedonist\Services\FileNameGenerator;
use Illuminate\Support\Facades\Storage;

class SaveUserListAction
{
    const FILE_STORAGE = 'upload/photo/';
    private $userListRepository;

    public function __construct(UserListRepositoryInterface $userListRepository)
    {
        $this->userListRepository = $userListRepository;
    }

    public function execute(SaveUserListRequest $userListRequest): SaveUserListResponse
    {
        $id = $userListRequest->getId();
        if (!$id) {
            $userList = new UserList;
        } else {
            $userList = $this->userListRepository->getById($id);
        }

        $file = $userListRequest->getImage();
        $imageName = (new FileNameGenerator($file))->generateFileName();
        Storage::disk('public')->putFileAs(self::FILE_STORAGE, $file, $imageName, 'public');
        $userList->user_id = $userListRequest->getUserId();
        $userList->name = $userListRequest->getName();
        $userList->img_url = Storage::disk()->url(self::FILE_STORAGE . $imageName);

        $userList = $this->userListRepository->save($userList);
        $this->userListRepository
            ->attachPlaces($userList, $userListRequest->getAttachedPlaces());

        return new SaveUserListResponse($userList);
    }
}