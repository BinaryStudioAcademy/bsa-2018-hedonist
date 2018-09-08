<?php

namespace Hedonist\Actions\User\Notifications;

class GetNotificationsAction
{
    public function execute(GetNotificationsRequest $request): GetNotificationsResponse
    {
        return new GetNotificationsResponse(auth()->user()->notifications);
    }
}