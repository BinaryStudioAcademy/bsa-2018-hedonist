<?php

namespace Hedonist\Actions\Auth\Requests;


interface RegisterRequestInterface
{

    public function getEmail(): string;

    public function getPassword(): string;

    public function getName(): string;
}