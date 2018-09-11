<?php

namespace Hedonist\Notifications;

use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FollowedUserUpdateListNotification extends Notification
{
    use Queueable;

    private $userList;
    private $subjectUser;
    private $detachedPlaces;
    private $attachedPlaces;

    public function __construct(
        UserList $userList,
        Collection $detachedPlaces,
        Collection $attachedPlaces,
        User $subjectUser
    ) {
        $this->userList = $userList;
        $this->subjectUser = $subjectUser;
        $this->detachedPlaces = $detachedPlaces;
        $this->attachedPlaces = $attachedPlaces;
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

    public function toArray($notifiable)
    {
        return [
            'notification' => 123,
        ];
    }

    private function notificationMessage(User $subjectUser): array
    {
        return [
            'subject' => [
                'id' => $this->userList->id,
                'name' => $this->userList->name,
                'detached_places' => $this->detachedPlaces->map(function ($place) {
                    return [
                        'id' => $place->id,
                        'localization' => $place->localization->map(function ($localization) {
                            return [
                                'place_name' => $localization->place_name,
                                'language' => [
                                    'id' => $localization->language->id,
                                    'en' => $localization->language->code
                                ]
                            ];
                        })->toArray()
                    ];
                })->toArray(),
                'attached_places' => $this->attachedPlaces->map(function ($place) {
                    return [
                        'id' => $place->id,
                        'localization' => $place->localization->map(function ($localization) {
                            return [
                                'place_name' => $localization->place_name,
                                'language' => [
                                    'id' => $localization->language->id,
                                    'en' => $localization->language->code
                                ]
                            ];
                        })->toArray()
                    ];
                })->toArray(),
            ],
            'subject_user' => [
                'id' => $subjectUser->id,
                'info' => [
                    'first_name' => $subjectUser->info->first_name,
                    'avatar_url' => $subjectUser->info->avatar_url
                ]
            ],
            'type' => self::class
        ];
    }
}
