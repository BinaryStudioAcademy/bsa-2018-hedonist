<?php

namespace Hedonist\Response\UserList;

interface UserListResponseInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getUserId(): int;

    public function getImgUrl(): string;
}