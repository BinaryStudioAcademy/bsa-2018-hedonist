<?php

namespace Hedonist\ElasticSearch\Mappers;

use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\User;
use Illuminate\Database\Eloquent\Model;

class ReviewMapper implements MapperInterface
{
    private $userMapper;

    public function __construct(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    private function canMap(Model $model): void
    {
        if (!$model instanceof Review) {
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
            'user' => $this->userMapper->map($model->user),
            'photos' => $model->photos,
            'likes' => $model->likes,
            'likes_count' => $model->likes->count(),
            'dislikes' => $model->dislikes,
            'created_at' => $model->created_at->format('Y-m-d H:i:s')
        ];
    }
}