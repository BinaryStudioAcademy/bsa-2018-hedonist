<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Support\Collection;

class GetUserListResponse
{
    private $userList;
    private $places;
    private $user;

    public function __construct(UserList $userList, Collection $places, User $user)
    {
        $this->userList = $userList;
        $this->places = $places;
        $this->user = $user;
    }

    public function getUserList(): UserList
    {
        return $this->userList;
    }

    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}