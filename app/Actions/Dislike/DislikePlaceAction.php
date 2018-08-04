<?php

namespace Hedonist\Actions\Dislike;

use Hedonist\Repositories\Dislike\DislikeRepository;

class DislikePlaceAction
{
    private $dislikeRepository;

    public function __construct(DislikeRepository $dislikeRepository)
    {
        $this->dislikeRepository = $dislikeRepository;
    }

    public function execute(DislikePlaceRequest $request): DislikePlaceResponse
    {
        // TODO: Implement execute() method.
    }
}