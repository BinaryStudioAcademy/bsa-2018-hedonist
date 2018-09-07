<?php

namespace Hedonist\Actions\User\Notifications;

use Illuminate\Notifications\DatabaseNotification;

class GetNotificationsPresenter
{
    public function presentCollection(GetNotificationsResponse $response)
    {
        return $response->getNotificationCollection()->map(
            function (DatabaseNotification $notification) {
                return [
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at
                ];
            })->toArray();
    }
}