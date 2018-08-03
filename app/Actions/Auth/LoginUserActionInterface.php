<?php

namespace Hedonist\Actions\Auth;


use Hedonist\Actions\Auth\Requests\LoginRequestInterface;
use Hedonist\Actions\Auth\Responses\LoginResponseInterface;

interface LoginUserActionInterface
{
    public function execute(LoginRequestInterface $request): LoginResponseInterface;
}