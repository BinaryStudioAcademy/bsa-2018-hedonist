<?php

namespace Hedonist\Actions\UserList;

class SaveUserListRequest
{
    private $id;
    private $imgUrl;
    private $name;
    private $userId;

    public function __construct(int $userId, string $name, string $imgUrl, int $id = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->imgUrl = $imgUrl;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}