<?php

namespace Hedonist\Policies;

use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserListPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, UserList $userList)
    {
        return $user->id === $userList->user_id;
    }
}
