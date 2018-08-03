<?php

namespace Hedonist\Actions\Auth\Requests;


use Hedonist\Actions\RequestInterface;

class ResetPasswordRequest implements RequestInterface
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail():string
    {
        return $this->email;
    }
}