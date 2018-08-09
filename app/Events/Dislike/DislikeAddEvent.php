<?php

namespace Hedonist\Events\Dislike;

use Hedonist\Entities\Dislike\Dislike;
use Illuminate\Queue\SerializesModels;

class DislikeAddEvent
{
    use SerializesModels;

    private $dislike;

    public function __construct(Dislike $dislike)
    {
        $this->dislike = $dislike;
    }

    public function getDislike(): Dislike
    {
        return $this->dislike;
    }
}
