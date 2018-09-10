<?php

namespace Hedonist\Actions\Review;

use Hedonist\ElasticSearch\Criterias\Common\ElasticPaginationCriteria;
use Hedonist\Repositories\Review\Criterias\DefaultSortCriteria;
use Hedonist\Repositories\Review\Criterias\ElasticCriterias\ReviewByPlaceIdCriteria;
use Hedonist\Repositories\Review\Criterias\ElasticCriterias\ReviewDefaultSortCriteria;
use Hedonist\Repositories\Review\Criterias\ElasticCriterias\ReviewDescriptionFulltextCriteria;
use Hedonist\Repositories\Review\Criterias\ElasticCriterias\ReviewPopularSortCriteria;
use Hedonist\Repositories\Review\Criterias\ElasticCriterias\ReviewUsernameFulltextCriteria;
use Hedonist\Repositories\Review\Criterias\GetReviewsByTextCriteria;
use Hedonist\Repositories\Review\Criterias\GetReviewsByPlaceCriteria;
use Hedonist\Repositories\Review\Criterias\PopularSortCriteria;
use Hedonist\Repositories\Review\Criterias\ReviewPaginationCriteria;
use Hedonist\Repositories\Review\Criterias\SortCriteria;
use Hedonist\Repositories\Review\ElasticReviewRepositoryInterface;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewCollectionAction
{
    private $reviewRepository;
    private $elasticReviewRepository;

    public function __construct(
        ElasticReviewRepositoryInterface $repository,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->elasticReviewRepository = $repository;
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
            $criterias[] = new ReviewByPlaceIdCriteria($placeId);
        } else {
            $totalCount = $this->reviewRepository->getTotalCount();
        }

        if (!is_null($text)) {
            $criterias[] = new ReviewDescriptionFulltextCriteria($text);
            $criterias[] = new ReviewUsernameFulltextCriteria($text);
        }

        if ($sort === PopularSortCriteria::POPULAR_SORT) {
            $criterias[] = new ReviewPopularSortCriteria();
        } else {
            $criterias[] = new ReviewDefaultSortCriteria();
        }

        $reviews = $this->elasticReviewRepository->findCollectionByCriterias(
            new ElasticPaginationCriteria($page),
            ...$criterias
        );

        return new GetReviewCollectionResponse($reviews, $totalCount, ElasticPaginationCriteria::LIMIT);
    }
}
