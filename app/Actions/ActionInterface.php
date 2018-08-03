<?php

namespace Hedonist\Actions;

use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;

interface ActionInterface
{
    public function execute(RequestInterface $request): ResponseInterface;
}