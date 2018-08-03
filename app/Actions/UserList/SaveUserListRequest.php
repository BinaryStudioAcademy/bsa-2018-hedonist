<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Actions\RequestInterface;

class SaveUserListRequest implements RequestInterface
{
    private $id;
    private $imgUrl;
    private $name;
    private $userId;

    public function __construct($id = null, $userId, $name, $imgUrl)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->imgUrl = $imgUrl;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}