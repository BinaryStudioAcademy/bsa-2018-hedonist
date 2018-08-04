<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\RecoverPasswordRequest;
use Hedonist\Exceptions\Auth\PasswordResetEmailSentException;
use Illuminate\Support\Facades\Password;

class RecoverPasswordAction
{
    public function execute(RecoverPasswordRequest $request)
    {
        $success = Password::broker()->sendResetLink(['email' => $request->getEmail()]);

        if ($success !== Password::RESET_LINK_SENT) {
            throw new PasswordResetEmailSentException();
        }
    }
}