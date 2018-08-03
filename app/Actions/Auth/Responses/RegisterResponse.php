<?php

namespace Hedonist\Actions\Auth\Responses;


class RegisterResponse implements RegisterResponseInterface
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