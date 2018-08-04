<?php

namespace Hedonist\Actions\Auth\Requests;

class RecoverPasswordRequest
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}