<?php

namespace Hedonist\Actions\Presenters\Review;

use Hedonist\Actions\Presenters\PresentsCollection;
use Hedonist\Actions\Presenters\User\UserPresenter;
use Hedonist\Entities\Review\Review;

class ReviewPresenter
{
    use PresentsCollection;

    private $usersPresenter;

    public function __construct(UserPresenter $presenter)
    {
        $this->usersPresenter = $presenter;
    }

    public function present(Review $review): array
    {
        return [
            'id' => $review->id,
            'place_id' => $review->place_id,
            'created_at' => $review->created_at->format('Y-m-d'),
            'description' => $review->description,
            'user' => $this->usersPresenter->present($review->user),
            'likes' => $review->likes->count(),
            'dislikes' => $review->dislikes->count(),
        ];
    }
}
