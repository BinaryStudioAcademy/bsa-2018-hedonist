<?php

namespace Hedonist\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordLinkSent extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $token;

    public function __construct($user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this
            ->from('admin@hedonist.com')
            ->view('emails.resetPassword')
            ->with([
                'firstName' => $this->user->info->first_name,
                'lastName'  => $this->user->info->last_name,
                'token'     => $this->token,
            ]);
    }
}
