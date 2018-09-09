<?php

namespace Hedonist\Notifications;

use Hedonist\Entities\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FollowedUserDeleteListNotification extends Notification
{
    use Queueable;

    private $userListName;
    private $subjectUser;

    public function __construct($userListName, User $subjectUser)
    {
        $this->userListName = $userListName;
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
            'subject' => $this->userListName,
            'subject_user' => $subjectUser,
            'type' => self::class
        ];
    }
}
