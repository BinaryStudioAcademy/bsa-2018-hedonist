<?php

namespace Hedonist\Events\Auth;

class PasswordResetedEvent
{
    private $email;
    private $token;
    public function __construct(string $email,string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }
}