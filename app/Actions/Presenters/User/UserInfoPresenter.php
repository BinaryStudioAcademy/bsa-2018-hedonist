<?php

namespace Hedonist\Actions\Presenters\User;

use Hedonist\Entities\User\UserInfo;

class UserInfoPresenter
{
    public function present(UserInfo $info):array
    {
        return $info->toArray();
    }
}