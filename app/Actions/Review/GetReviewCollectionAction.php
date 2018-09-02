<?php

namespace Hedonist\Actions\Review;

use Hedonist\Actions\Presenters\Review\ReviewPresenter;
use Hedonist\Repositories\Review\Criterias\DefaultSortCriteria;
use Hedonist\Repositories\Review\Criterias\GetReviewsByTextCriteria;
use Hedonist\Repositories\Review\Criterias\GetReviewsByPlaceCriteria;
use Hedonist\Repositories\Review\Criterias\ReviewPaginationCriteria;
use Hedonist\Repositories\Review\Criterias\SortCriteria;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewCollectionAction
{
    private const DEFAULT_SORT = 'created_at';
    private const DEFAULT_ORDER = 'desc';

    private $reviewRepository;
    private $reviewPresenter;

    public function __construct(ReviewRepositoryInterface $repository, ReviewPresenter $reviewPresenter)
    {
        $this->reviewRepository = $repository;
        $this->reviewPresenter = $reviewPresenter;
    }

    public function execute(GetReviewCollectionRequest $request): GetReviewCollectionResponse
    {
        $page = $request->getPage() ?? GetReviewCollectionRequest::DEFAULT_PAGE;
        $placeId = $request->getPlaceId();
        $sort = $request->getSort() ?? self::DEFAULT_SORT;
        $order = $request->getOrder() ?? self::DEFAULT_ORDER;
        $text = $request->getText();

        $criterias = [];

        if (!is_null($placeId)) {
            $totalCount = $this->reviewRepository->getTotalCountByPlace($placeId);
            $criterias[] = new GetReviewsByPlaceCriteria($placeId);
        } else {
            $totalCount = $this->reviewRepository->getTotalCount();
        }

        if (!is_null($text)) {
            $criterias[] = new GetReviewsByTextCriteria($text);
        }

        if ($sort !== self::DEFAULT_SORT) {
            $criterias[] = new DefaultSortCriteria;
        }

        $reviews = $this->reviewRepository
            ->findCollectionByCriterias(
                new SortCriteria($sort, $order),
                new ReviewPaginationCriteria($page),
                ...$criterias
            )
            ->map(function ($review) {
                return $this->reviewPresenter->present($review);
            });

        return new GetReviewCollectionResponse($reviews, $totalCount, ReviewPaginationCriteria::LIMIT);
    }
}
