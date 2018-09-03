<?php

namespace Hedonist\Actions\Review;

use Illuminate\Support\Collection;

class GetUsersWhoLikedReviewResponse
{
    private $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    public function getUsers(): array
    {
        return $this->users->all();
    }
}
