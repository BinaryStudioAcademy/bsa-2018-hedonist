<?php

namespace Hedonist\Request\UserList;

interface UserListRequestInterface
{
    public function getUserId(): int;

    public function getName(): string;

    public function getImgUrl(): string;
}