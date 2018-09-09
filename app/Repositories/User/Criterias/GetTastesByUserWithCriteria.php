<?php

namespace Hedonist\Repositories\User\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetTastesByUserWithCriteria implements CriteriaInterface
{
    private $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $userId = $this->userId;
        return $model->whereHas(
            'users',
            function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }
        )->orWhere('is_default', true);
    }
}