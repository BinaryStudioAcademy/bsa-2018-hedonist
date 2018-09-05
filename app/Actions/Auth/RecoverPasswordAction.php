<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\RecoverPasswordRequest;
use Hedonist\Exceptions\Auth\PasswordResetEmailSentException;
use Hedonist\Mail\ResetPasswordLinkSent;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Mail;

class RecoverPasswordAction
{
    private $broker;

    public function __construct(PasswordBroker $broker)
    {
        $this->broker = $broker;
    }

    public function execute(RecoverPasswordRequest $request)
    {
        $user = $this->broker->getUser(['email' => $request->getEmail()]);

        if (is_null($user)) {
            throw new PasswordResetEmailSentException();
        }

        $token = $this->broker->createToken($user);

        try {
            Mail::to($user)->send(new ResetPasswordLinkSent($user, $token));
        } catch (\Throwable $e) {
            throw new PasswordResetEmailSentException();
        }
    }
}
