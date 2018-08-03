<?php

namespace Hedonist\Request\UserList;

class UserListRequest implements UserListRequestInterface
{
    private $userId;
    private $name;
    private $imgUrl;

    public function __construct(int $userId, string $name, string $imgUrl)
    {
        $this->name = $name;
        $this->userId = $userId;
        $this->imgUrl = $imgUrl;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }
}