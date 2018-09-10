<?php

namespace Hedonist\ElasticSearch\Mappers;

use Hedonist\Entities\Review\Review;
use Illuminate\Database\Eloquent\Model;

class ReviewMapper implements MapperInterface
{
    private function canMap(Model $model): void
    {
        if(!$model instanceof Review){
            throw new \RuntimeException('Incorrect type for mapping');
        }
    }

    public function map(Model $model): array
    {
        $this->canMap($model);
        return [
            'id' => $model->id,
            'description' => $model->description,
            'place_id' => $model->place_id,
            'user' => $model->user,
            'photos' => $model->photos,
            'likes' => $model->likes,
            'dislikes' => $model->dislikes,
        ];
    }
}