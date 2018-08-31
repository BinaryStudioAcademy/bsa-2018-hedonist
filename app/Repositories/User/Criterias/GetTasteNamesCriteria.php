<?php

namespace Hedonist\Repositories\User\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetTasteNamesCriteria implements CriteriaInterface
{
    private $userId;
    private $query;

    public function __construct(int $userId, string $query)
    {
        $this->userId = $userId;
        $this->query = $query;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where([
            ['user_id', '!=', $this->userId],
            ['is_default', false],
            ['name', 'like', "%{$this->query}%"]
        ]);
    }
}