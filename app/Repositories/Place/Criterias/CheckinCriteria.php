<?php

namespace Hedonist\Repositories\Place\Criterias;

use Hedonist\Entities\User\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CheckinCriteria implements CriteriaInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('checkins', function ($query){
            $query->where('user_id', $this->user->id);
        });
    }
}