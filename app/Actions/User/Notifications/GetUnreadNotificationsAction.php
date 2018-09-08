<?php

namespace Hedonist\Actions\User\Notifications;

class GetUnreadNotificationsAction
{
    public function execute(GetNotificationsRequest $request): GetNotificationsResponse
    {
        return new GetNotificationsResponse(auth()->user()->unreadNotifications);
    }
}