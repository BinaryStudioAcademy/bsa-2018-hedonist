<?php

namespace Hedonist\Actions\Review;

use Illuminate\Database\Eloquent\Collection;

class GetReviewUsersLikedResponse
{
    private $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function getUsers(): array
    {
        return $this->users;
    }
}
