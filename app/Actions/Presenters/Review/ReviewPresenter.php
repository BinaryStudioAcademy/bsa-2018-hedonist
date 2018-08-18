<?php

namespace Hedonist\Actions\Place\Presenters\Review;

use Hedonist\Actions\Presenters\PresentsCollectionTrait;
use Hedonist\Actions\Presenters\User\UserPresenter;
use Hedonist\Entities\Review\Review;

class ReviewPresenter
{
    use PresentsCollectionTrait;

    private  $usersPresenter;

    public function __construct(UserPresenter $presenter)
    {
        $this->usersPresenter = $presenter;
    }

    public function present(Review $review, ?int $userId = null): array
    {
        return [
            'created_at' => $review->created_at,
            'description' => $review->description,
            'user' => $this->usersPresenter->present($review->user),
            'likes' => $review->likes->count(),
            'dislikes' => $review->dislikes->count(),
        ];
    }
}