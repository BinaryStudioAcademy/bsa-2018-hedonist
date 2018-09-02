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
            'created_at' => $review->created_at->format('Y-m-d H:i:s'),
            'description' => $review->description,
            'user' => $this->usersPresenter->present($review->user),
            'likes' => $review->likes_count,
            'dislikes' => $review->dislikes_count,
        ];
    }
}