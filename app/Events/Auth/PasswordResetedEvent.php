<?php

namespace Hedonist\Events\Auth;

use Hedonist\Entities\User;

class PasswordResetedEvent
{
    private $user;
    private $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}