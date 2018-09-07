<?php

namespace Hedonist\Actions\User\Notifications;

class DeleteNotificationsAction
{
    public function execute(): void
    {
        auth()->user()->notifications()->delete();
    }
}