<?php

namespace Hedonist\Actions\User\Notifications;

class ReadNotificationsAction
{
    public function execute()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}