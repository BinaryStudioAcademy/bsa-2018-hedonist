<?php

namespace Hedonist\Actions\Like;

use Hedonist\Actions\{ActionInterface, RequestInterface, ResponseInterface};
use Hedonist\Repositories\Like\LikeRepository;

class DislikePlaceAction
{
    private $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        // TODO: Implement execute() method.
    }
}