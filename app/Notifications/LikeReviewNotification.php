<?php

namespace Hedonist\Notifications;

use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class LikeReviewNotification extends Notification
{
    use Queueable;

    private $review;
    private $subjectUser;

    public function __construct(Review $review, User $subjectUser)
    {
        $this->review = $review;
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
            'user' => $notifiable
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'notification' => $this->notificationMessage($this->subjectUser),
            'user' => $notifiable
        ]);
    }

    private function notificationMessage(User $subjectUser)
    {
        return [
            'subject' => $this->review,
            'subject_user' => $subjectUser
        ];
    }
}
