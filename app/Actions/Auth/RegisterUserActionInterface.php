<?php

namespace Hedonist\Actions\Auth;


use Hedonist\Actions\Auth\Requests\RegisterRequestInterface;
use Hedonist\Actions\Auth\Responses\RegisterResponseInterface;

interface RegisterUserActionInterface
{
    public function execute(RegisterRequestInterface $request):RegisterResponseInterface;
}