<?php

namespace Hedonist\Actions\Auth\Responses;


use Hedonist\Actions\ResponseInterface;

class RefreshResponse implements ResponseInterface
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