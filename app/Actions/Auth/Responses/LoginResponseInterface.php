<?php

namespace Hedonist\Actions\Auth\Responses;


interface LoginResponseInterface
{
    public function getToken(): string;
}