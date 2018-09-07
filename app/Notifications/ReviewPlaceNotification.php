<?php

namespace Hedonist\Notifications;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ReviewPlaceNotification extends Notification
{
    use Queueable;

    private $place;
    private $subjectUser;

    public function __construct(Place $place, User $subjectUser)
    {
        $this->place = $place;
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
            'subject' => $this->place,
            'subject_user' => $subjectUser,
            'type' => self::class
        ];
    }
}
