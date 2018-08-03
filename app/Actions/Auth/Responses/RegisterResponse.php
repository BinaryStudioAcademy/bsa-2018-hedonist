<?php

namespace Hedonist\Actions\Auth\Responses;


use Hedonist\Actions\ResponseInterface;

class RegisterResponse implements ResponseInterface
{
    private $success;

    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }
}