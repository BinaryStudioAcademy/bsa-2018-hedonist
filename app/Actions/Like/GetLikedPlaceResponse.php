<?php

namespace Hedonist\Actions\Like;

class GetLikedPlaceResponse
{
    private $liked;

    public function __construct(string $liked)
    {
        $this->liked = $liked;
    }

    public function getLiked()
    {
        return $this->liked;
    }
}