<?php

namespace Hedonist\Listeners;

use Hedonist\Events\Auth\PasswordResetedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Hedonist\Mail\ResetPasswordLinkSent;

class PasswordResetedEventListener
{
    public function handle(PasswordResetedEvent $event)
    {
        $user = $event->getUser();
        $token = $event->getToken();

        $message = (new ResetPasswordLinkSent($user, $token))
            ->onConnection('rabbitmq')
            ->onQueue('rabbit');
        
        Mail::to($user)->queue($message);
    }
}
