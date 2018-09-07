<?php

namespace Hedonist\Actions\User\Notifications;

class DeleteNotificationsAction
{
    public function execute(DeleteNotificationsRequest $request)
    {
        auth()->user()->notifications()->delete();
    }
}