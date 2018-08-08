<?php

namespace Hedonist\Actions\Auth\Responses;

class ResetPasswordResponse implements AuthenticateResponseInterface
{
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}