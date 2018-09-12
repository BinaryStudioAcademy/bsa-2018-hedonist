<?php

namespace Hedonist\Actions\User\Notifications;

class GetUnreadNotificationsAction
{
    public function execute(): GetNotificationsResponse
    {
        return new GetNotificationsResponse(auth()->user()->unreadNotifications);
    }
}