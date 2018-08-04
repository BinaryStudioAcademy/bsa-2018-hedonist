<?php

namespace Hedonist\Actions\Auth\Responses;

interface AuthenticateResponseInterface
{
    public function getToken():string;
}