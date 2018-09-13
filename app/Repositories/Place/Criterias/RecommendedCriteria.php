<?php

namespace Hedonist\Repositories\Place\Criterias;

use Hedonist\Entities\User\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class RecommendedCriteria implements CriteriaInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $userTastesIds = $this->user->tastes->pluck('id', 'name');

        $result = $model->where( function(Builder $query) use ($userTastesIds) {
            $query->whereHas('tastes', function (Builder $query) use ($userTastesIds) {
                $query->whereIn('tastes.id', $userTastesIds);
            });

            foreach ($userTastesIds as $name => $id) {
                $query->orWhereHas('reviews', function (Builder $query) use ($name) {
                    $query->where('description', 'like', "%{$name}%");
                });
            }    
        });

        return $result;
    }
}
