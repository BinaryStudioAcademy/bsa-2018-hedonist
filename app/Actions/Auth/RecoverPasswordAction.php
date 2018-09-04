<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\RecoverPasswordRequest;
use Hedonist\Exceptions\Auth\PasswordResetEmailSentException;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;

class RecoverPasswordAction
{
    private $broker;

    public function __construct(PasswordBroker $broker)
    {
        $this->broker = $broker;
    }

    public function execute(RecoverPasswordRequest $request)
    {
        $success = $this->broker->sendResetLink(['email' => $request->getEmail()]);

        if ($success === Password::INVALID_USER) {
            throw new PasswordResetEmailSentException();
        }
    }
}
