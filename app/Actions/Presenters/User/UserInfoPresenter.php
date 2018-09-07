<?php

namespace Hedonist\Actions\Presenters\User;

use Hedonist\Entities\User\UserInfo;

class UserInfoPresenter
{
    public function present(UserInfo $info): array
    {
        $result = $info->toArray();
        if ($info->date_of_birth) {
            $result['date_of_birth'] = $info->date_of_birth->format('Y/m/d');
        }
        unset($result['id']);
        return $result;
    }
}