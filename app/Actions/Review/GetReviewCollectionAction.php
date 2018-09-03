<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\Criterias\DefaultSortCriteria;
use Hedonist\Repositories\Review\Criterias\GetReviewsByTextCriteria;
use Hedonist\Repositories\Review\Criterias\GetReviewsByPlaceCriteria;
use Hedonist\Repositories\Review\Criterias\ReviewPaginationCriteria;
use Hedonist\Repositories\Review\Criterias\SortCriteria;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewCollectionAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(GetReviewCollectionRequest $request): GetReviewCollectionResponse
    {
        $page = $request->getPage() ?? GetReviewCollectionRequest::DEFAULT_PAGE;
        $placeId = $request->getPlaceId();
        $sort = $request->getSort() ?? DefaultSortCriteria::DEFAULT_SORT;
        $order = $request->getOrder() ?? DefaultSortCriteria::DEFAULT_ORDER;
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

        if ($sort !== DefaultSortCriteria::DEFAULT_SORT) {
            $criterias[] = new DefaultSortCriteria;
        }

        $reviews = $this->reviewRepository->findCollectionByCriterias(
            new SortCriteria($sort, $order),
            new ReviewPaginationCriteria($page),
            ...$criterias
        );

        return new GetReviewCollectionResponse($reviews, $totalCount, ReviewPaginationCriteria::LIMIT);
    }
}
