<?php

namespace Hedonist\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Hedonist\Events\Like\LikeAddEvent' => [
            'Hedonist\Listeners\LikeAddEventListener',
        ],
        'Hedonist\Events\Dislike\DislikeAddEvent' => [
            'Hedonist\Listeners\DislikeAddEventListener',
        ],
        'Hedonist\Events\Auth\PasswordResetedEvent' => [
            'Hedonist\Listeners\PasswordResetedEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
