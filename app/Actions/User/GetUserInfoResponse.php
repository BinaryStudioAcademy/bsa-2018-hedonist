<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\User;
use Illuminate\Support\Collection;

class GetUserInfoResponse
{
    private $user;
    private $followers;
    private $followed;

    public function __construct(User $user, Collection $followers, Collection $followed)
    {
        $this->user = $user;
        $this->followers = $followers;
        $this->followed = $followed;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getFollowed(): Collection
    {
        return $this->followed;
    }

    public function getFollowers(): Collection
    {
        return $this->followers;
    }
}