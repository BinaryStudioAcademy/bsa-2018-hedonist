<?php

namespace Hedonist\Notifications;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class UserUnfollowNotification extends Notification
{
    use Queueable;

    private $subjectUser;

    public function __construct(User $subjectUser)
    {
        $this->subjectUser = $subjectUser;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'notification' => $this->notificationMessage($this->subjectUser),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'notification' => $this->notificationMessage($this->subjectUser),
        ]);
    }

    private function notificationMessage(User $subjectUser)
    {
        return [
            'subject' => $subjectUser,
            'subject_user' => $subjectUser,
            'type' => self::class
        ];
    }
}
