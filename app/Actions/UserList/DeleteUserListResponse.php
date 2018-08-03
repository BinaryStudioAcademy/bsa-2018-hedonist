<?php

namespace Hedonist\Actions\UserList;

use Hedonist\Actions\ResponseInterface;

class DeleteUserListResponse implements ResponseInterface
{
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function result()
    {
        $result = ['result' => 'success'];
        if (!$result) {
            $result['result'] = 'error';
        }
        return $result;
    }
}