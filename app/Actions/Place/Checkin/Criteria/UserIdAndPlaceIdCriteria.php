<?php

namespace Hedonist\Actions\Place\Checkin\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UserIdAndPlaceIdCriteria implements CriteriaInterface
{
    protected $userId;
    protected $placeId;

    public function __construct(int $userId, int $placeId)
    {
        $this->userId = $userId;
        $this->placeId = $placeId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where([
            ['user_id','=', $this->userId],
            ['place_id','=', $this->placeId],
        ]);
        return $model;
    }
}