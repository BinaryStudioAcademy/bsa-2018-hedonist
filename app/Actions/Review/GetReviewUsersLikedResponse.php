<?php

namespace Hedonist\Actions\Review;

use Illuminate\Database\Eloquent\Collection;

class GetReviewUsersLikedResponse
{
    private $userCollection;

    public function __construct(Collection $users)
    {
        $this->userCollection = $users;
    }

    public function getUserCollection(): array
    {
        return $this->userCollection->toArray();
    }
}
