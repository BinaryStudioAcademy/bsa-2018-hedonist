<?php

namespace Hedonist\Actions\User\Notifications;

class GetNotificationsAction
{
    public function execute(): GetNotificationsResponse
    {
        return new GetNotificationsResponse(auth()->user()->notifications);
    }
}