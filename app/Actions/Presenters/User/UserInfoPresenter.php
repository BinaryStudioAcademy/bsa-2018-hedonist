<?php

namespace Hedonist\Actions\Presenters\User;

use Hedonist\Entities\User\UserInfo;

class UserInfoPresenter
{
    public function present(UserInfo $info):array
    {
        return [
            'avatar_url' => $info->avatar_url,
            'first_name' => $info->first_name,
            'last_name' => $info->last_name
        ];
    }
}