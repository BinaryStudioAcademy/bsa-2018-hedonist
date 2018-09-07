<?php

namespace Hedonist\Actions\User\Notifications;

class ReadNotificationsAction
{
    public function execute(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}