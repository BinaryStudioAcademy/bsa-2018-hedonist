<?php

namespace Hedonist\Actions\User;

use Hedonist\Actions\Presenters\User\UserPresenter;
use Illuminate\Support\Facades\Auth;

class GetUserInfoPresenter
{
    private $userPresenter;

    public function __construct(UserPresenter $presenter)
    {
        $this->userPresenter = $presenter;
    }

    public function present(GetUserInfoResponse $response)
    {
        $user = $this->userPresenter->present($response->getUser());

        if ($user['is_private'] && $user['id'] !== Auth::id()) {
            $result = [
                'id' => $user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'avatar_url' => $user['avatar_url'],
                'is_private' => (bool)$user['is_private']
            ];
        } else {
            $result = $user;
            $result['followers'] = $this->userPresenter->presentCollection($response->getFollowers());
            $result['followedUsers'] = $this->userPresenter->presentCollection($response->getFollowed());
        }

        return $result;
    }
}