<?php

namespace Hedonist\Actions\Auth\Requests;


interface RegisterUserRequestInterface
{
    public function __construct(string $email, string $password);

    public function getEmail(): string;

    public function getPassword(): string;
}