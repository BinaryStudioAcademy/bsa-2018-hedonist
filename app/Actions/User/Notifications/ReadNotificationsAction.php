<?php

namespace Hedonist\Actions\User\Notifications;

class ReadNotificationsAction
{
    public function execute(ReadNotificationsRequest $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}