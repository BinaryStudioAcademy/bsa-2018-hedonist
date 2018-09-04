<?php

namespace Hedonist\Notifications;

use Hedonist\Entities\Like\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class UserNotification extends Notification
{
    use Queueable;

    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'thread' => $this->like,
            'user' => $notifiable
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'thread' => $this->like,
            'user' => $notifiable
        ]);
    }
}
