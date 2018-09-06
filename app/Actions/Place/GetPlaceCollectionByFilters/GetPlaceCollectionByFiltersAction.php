<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionByFilters;

use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionResponse;
use Hedonist\Entities\Place\Location;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Polygon;
use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Exceptions\Place\PlacePolygonInvalidException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\CheckinCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceBySpecialFeatureCriteria;
use Hedonist\Repositories\Place\Criterias\RecommendedCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByTagCriteria;
use Hedonist\Repositories\Place\Criterias\SavedCriteria;
use Hedonist\Repositories\Place\Criterias\OpenedCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByCategoryCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByLocationCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByPolygonCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByNameCriteria;
use Hedonist\Repositories\Place\Criterias\LatestReviewForPlaceCriteria;
use Hedonist\Repositories\Place\Criterias\PlacePaginationCriteria;
use Hedonist\Repositories\Place\Criterias\TopRatedCriteria;
use Hedonist\Repositories\Place\Criterias\TopReviewedCriteria;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\Repository as Cache;

class GetPlaceCollectionByFiltersAction
{
    const SEARCH_KEY_PREFIX = 'search_places-';
    const CACHE_TIME = 30;

    private $placeRepository;
    private $cache;

    public function __construct(PlaceRepositoryInterface $placeRepository, Cache $cache)
    {
        $this->placeRepository = $placeRepository;
        $this->cache = $cache;
    }

    public function execute(GetPlaceCollectionByFiltersRequest $request): GetPlaceCollectionResponse
    {
        $user = Auth::user();

        $uniqId = $this->generateUniqKeyByPlaceSearch($request);
        $cachePlaces = $this->cache->get(self::SEARCH_KEY_PREFIX . $uniqId);
        if ($cachePlaces) {
            return new GetPlaceCollectionResponse(unserialize($cachePlaces), $user);
        }

        $categoryId = $request->getCategoryId();
        $name = $request->getName();
        $location = $request->getLocation();
        $page = $request->getPage() ?: GetPlaceCollectionByFiltersRequest::DEFAULT_PAGE;
        $polygon = $request->getPolygon();
        $tags = $request->getTags();
        $features = $request->getFeatures();
        $criterias = [];

        if (!is_null($location)) {
            try {
                $location = Location::fromString($location);
            } catch (\InvalidArgumentException $e) {
                throw new PlaceLocationInvalidException($e->getMessage());
            }
            $criterias[] = new GetPlaceByLocationCriteria($location);
        }

        if (!is_null($categoryId)) {
            $criterias[] = new GetPlaceByCategoryCriteria($categoryId);
        }
        if (!is_null($polygon)) {
            try {
                $polygon = Polygon::fromString($polygon);
            } catch (\InvalidArgumentException $e) {
                throw PlacePolygonInvalidException::createFromMessage($e->getMessage());
            }
            $criterias[] = new GetPlaceByPolygonCriteria($polygon);
        }

        if (!is_null($tags)) {
            $tagsArray = explode(',', $tags);
            $criterias[] = new GetPlaceByTagCriteria($tagsArray);
        }

        if (!is_null($features)) {
            $featuresArray = explode(',', $features);
            $criterias[] = new GetPlaceBySpecialFeatureCriteria($featuresArray);
        }

        if (!is_null($name)) {
            $criterias[] = new GetPlaceByNameCriteria($name);
        }

        if ($request->isTopReviewed()) {
            $criterias[] = new TopReviewedCriteria;
        }

        if ($request->isTopRated()) {
            $criterias[] = new TopRatedCriteria;
        }

        if ($request->isCheckin()) {
            $criterias[] = new CheckinCriteria($user);
        }

        if ($request->isSaved()) {
            $criterias[] = new SavedCriteria($user);
        }

        if ($request->isRecommended()) {
            $criterias[] = new RecommendedCriteria($user);
        }

        if ($request->isOpened()) {
            $criterias[] = new OpenedCriteria;
        }

        $places = $this->placeRepository->findCollectionByCriterias(
            new PlacePaginationCriteria($page),
            new AllPlacePhotosCriteria(),
            new LatestReviewForPlaceCriteria(),
            ...$criterias
        );

        if (! $this->hasFilterParameters($request)) {
            $this->cache->put(self::SEARCH_KEY_PREFIX . $uniqId, serialize($places), self::CACHE_TIME);
        }

        return new GetPlaceCollectionResponse($places, $user);
    }

    private function generateUniqKeyByPlaceSearch(GetPlaceCollectionByFiltersRequest $request): string
    {
        $baseRequest = [
            $request->getPage(),
            $request->getCategoryId(),
            $request->getLocation(),
            $request->getName()
        ];
        return implode('_', $baseRequest);
    }

    private function hasFilterParameters(GetPlaceCollectionByFiltersRequest $request): bool
    {
        $fPolygon = $request->getPolygon();
        $fTopReviewed = $request->isTopReviewed();
        $fTopRated = $request->isTopRated();
        $fCheckin = $request->isCheckin();
        $fSaved = $request->isSaved();
        return $fPolygon || $fTopReviewed || $fTopRated || $fCheckin || $fSaved;
    }
}