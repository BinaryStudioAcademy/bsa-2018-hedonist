<?php

namespace Hedonist\Events\Like;

use Hedonist\Entities\Like\Like;
use Illuminate\Queue\SerializesModels;

class LikeAddEvent
{
    use SerializesModels;

    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function getLike(): Like
    {
        return $this->like;
    }
}
