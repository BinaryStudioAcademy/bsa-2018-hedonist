<?php

namespace Hedonist\Repositories\Place\Criterias;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OpenedCriteria implements CriteriaInterface
{
    private $today;

    public function __construct()
    {
        $this->today = Carbon::now('UTC');
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('worktime', function ($query) {
            $query->where('day_code', strtolower(substr($this->today->format('l'), 0, 2)))
                ->whereTime('start_time', '<=', $this->today->format('H:i'))
                ->whereTime('end_time', '>=', $this->today->format('H:i'));
        });
    }
}