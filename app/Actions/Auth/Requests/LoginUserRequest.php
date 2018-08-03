<?php

namespace Hedonist\Actions\Auth\Requests;


class LoginUserRequest implements RegisterUserRequestInterface
{
    private $email;
    private $password;

    public function __construct(string $email, string $password)
    {
        parent::__construct($email, $password);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}