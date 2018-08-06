<?php

namespace Hedonist\Actions\Review\Like;

use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Hedonist\Repositories\Review\ReviewRepository;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Facades\Auth;

class LikeReviewAction
{
    private $likeRepository;
    private $dislikeRepository;

    public function __construct(LikeRepository $likeRepository, DislikeRepository $dislikeRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
    }

    public function execute(LikeReviewRequest $request): LikeReviewResponse
   {
        $like = $this->likeRepository->findByCriteria($criteria);
        $dislike = $this->dislikeRepository->findByCriteria($criteria);
        //$like = $this->likeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        //$dislike = $this->dislikeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        if ($dislike) {
            $this->dislikeRepository->deleteById($dislike->id);
        }
        if (empty($like)) {
            $like = new Like([
                'likeable_id' => $request->getReviewId(),
                'likeable_type' => Review::class,
                'user_id' => Auth::id()
            ]);
            $this->likeRepository->save($like);
        }
        
        return new LikeReviewResponse();
    }
}