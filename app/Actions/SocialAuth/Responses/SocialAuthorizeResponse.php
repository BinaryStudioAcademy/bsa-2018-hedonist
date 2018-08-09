<?php

namespace Hedonist\Actions\SocialAuth\Responses;

use Hedonist\Actions\Auth\Responses\AuthenticateResponseInterface;

class SocialAuthorizeResponse implements AuthenticateResponseInterface
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