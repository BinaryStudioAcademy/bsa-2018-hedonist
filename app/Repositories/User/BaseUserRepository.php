<?php

namespace Hedonist\Repositories\User;


use Hedonist\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

class BaseUserRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}