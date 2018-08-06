<?php

namespace Hedonist\Actions\Auth\Requests;

class ResetPasswordRequest
{
    private $email;
    private $token;
    private $password;
    private $passwordConfirmation;

    public function __construct(string $email, string $password, string $passwordConfirmation, string $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}