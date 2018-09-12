<?php

namespace Hedonist\Providers;

use Hedonist\Events\Review\ReviewAddEvent;
use Hedonist\Events\Review\ReviewUpdatedEvent;
use Hedonist\Listeners\Review\ReviewUpdatedEventListener;
use Hedonist\Listeners\Review\ReviewAddEventListener;
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
        'Hedonist\Events\Review\ReviewAttitudeSetEvent' => [
            'Hedonist\Listeners\Review\ReviewAttitudeSetEventListener',
        ],
        ReviewAddEvent::class => [
            ReviewAddEventListener::class
        ],
        ReviewUpdatedEvent::class => [
            ReviewUpdatedEventListener::class
        ]
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
