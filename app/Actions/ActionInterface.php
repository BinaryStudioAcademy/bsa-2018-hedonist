<?php

namespace Hedonist\Actions;

use Hedonist\Requests\RequestInterface;
use Hedonist\Response\ResponseInterface;

interface ActionInterface
{
    public function execute(RequestInterface $request): ResponseInterface;

}