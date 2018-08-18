<?php

namespace Hedonist\Actions\Presenters\User;

use Illuminate\Foundation\Auth\User;

class UserPresenter
{
    private $userInfoPresenter;

    public function __construct(UserInfoPresenter $presenter)
    {
        $this->userInfoPresenter = $presenter;
    }

    public function present(User $user): array
    {
        return array_merge([
            'id' => $user->id,
            'email' => $user->email,
        ], $this->userInfoPresenter->present($user->info));
    }
}