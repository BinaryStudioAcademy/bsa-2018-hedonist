<?php

namespace Hedonist\Actions\User;

use Hedonist\Entities\User\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

class GetUserInfoResponse
{
    private $user;
    private $followers;
    private $followed;
    private $authenticatedUser;

    public function __construct(
        User $user,
        Authenticatable $authenticatedUser,
        Collection $followers,
        Collection $followed
    ) {
        $this->user = $user;
        $this->authenticatedUser = $authenticatedUser;
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

    public function getAuthenticatedUser(): Authenticatable
    {
        return $this->authenticatedUser;
    }
}