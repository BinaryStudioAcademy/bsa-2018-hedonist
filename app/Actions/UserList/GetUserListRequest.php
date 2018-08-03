<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Actions\RequestInterface;

class GetUserListRequest implements RequestInterface
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}