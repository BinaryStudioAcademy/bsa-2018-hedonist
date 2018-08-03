<?php

namespace Hedonist\Response\UserList;

class UserListResponse implements  UserListResponseInterface
{
    private $id;
    private $name;
    private $userId;
    private $imgUrl;

    public function __construct(int $id, string $name, int $userId, string $imgUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
        $this->imgUrl = $imgUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }
}