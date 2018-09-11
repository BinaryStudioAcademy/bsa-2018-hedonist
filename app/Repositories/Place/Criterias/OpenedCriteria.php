<?php

namespace Hedonist\Repositories\Place\Criterias;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OpenedCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $today = Carbon::now('UTC');

        return $model->whereHas('worktime', function ($query) use ($today) {
            $query->where('day_code', strtolower(substr($today->format('l'), 0, 2)))
                ->whereTime('start_time', '<=', $today->format('H:i'))
                ->whereTime('end_time', '>=', $today->format('H:i'));
        });
    }
}