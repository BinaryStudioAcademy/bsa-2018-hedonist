<?php

namespace Hedonist\Requests\Auth;

class RegisterRequest
{
    private $email;
    private $password;
    private $firstName;
    private $lastName;

    public function __construct(
        string $email,
        string $password,
        string $lastName,
        string $firstName
    )
    {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}