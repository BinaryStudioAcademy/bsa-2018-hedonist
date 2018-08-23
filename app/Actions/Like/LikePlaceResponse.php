<?php

namespace Hedonist\Actions\Like;

class LikePlaceResponse
{
    private $likes;
    private $dislikes;
    private $likedStatus;

    public function __construct(int $likes, int $dislikes, string $likedStatus)
    {
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->likedStatus = $likedStatus;
    }

    public function getLikes(): int 
    {
        return $this->likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }
    
    public function getLikedStatus(): string
    {
        return $this->likedStatus;
    }
}
