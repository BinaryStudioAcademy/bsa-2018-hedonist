<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;

class GetCollectionUserListAction implements ActionInterface
{
    public function execute(RequestInterface $request): ResponseInterface
    {
        $responseCollection = new GetCollectionUserListResponse([]);
        return $responseCollection;
    }
}