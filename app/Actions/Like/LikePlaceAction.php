<?php

namespace Hedonist\Actions\Like;

use Hedonist\Repositories\Like\LikeRepository;

class LikePlaceAction
{
    private $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function execute(LikePlaceRequest $request): LikePlaceResponse
    {
        // TODO: Implement execute() method.
    }
}