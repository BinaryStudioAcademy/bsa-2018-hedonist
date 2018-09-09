<?php

namespace Hedonist\Notifications;

use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FollowedUserUpdateListNotification extends Notification
{
    use Queueable;

    private $userList;
    private $subjectUser;

    public function __construct(UserList $userList, User $subjectUser)
    {
        $this->userList = $userList;
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
            'subject' => $this->userList,
            'subject_user' => $subjectUser,
            'type' => self::class
        ];
    }
}
