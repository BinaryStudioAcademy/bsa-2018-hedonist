<?php

namespace Hedonist\Actions\User\Notifications;

use Illuminate\Notifications\DatabaseNotificationCollection;

class GetNotificationsResponse
{
    private $notificationCollection;

    public function __construct(DatabaseNotificationCollection $notificationCollection)
    {
        $this->notificationCollection = $notificationCollection;
    }

    public function getNotificationCollection(): DatabaseNotificationCollection
    {
        return $this->notificationCollection;
    }
}