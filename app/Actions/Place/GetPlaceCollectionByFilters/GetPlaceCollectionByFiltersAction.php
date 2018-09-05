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
use Hedonist\Repositories\Place\Criterias\RecommendedCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByTagCriteria;
use Hedonist\Repositories\Place\Criterias\SavedCriteria;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class GetPlaceCollectionByFiltersAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceCollectionByFiltersRequest $request): GetPlaceCollectionResponse
    {
        $uniqId = $this->generateUniqKeyByPlaceSearch($request);
        $redisPlaces = Redis::get('search_places-' . $uniqId);
        if ($redisPlaces) {
            Log::debug('redis');
            return unserialize($redisPlaces);
        }
        Log::debug('not a redis');

        $categoryId = $request->getCategoryId();
        $name = $request->getName();
        $location = $request->getLocation();
        $page = $request->getPage() ?: GetPlaceCollectionByFiltersRequest::DEFAULT_PAGE;
        $polygon = $request->getPolygon();
        $tags = $request->getTags();
        $criterias = [];

        /** @var User $user */
        $user = Auth::user();

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

        $places = $this->placeRepository->findCollectionByCriterias(
            new PlacePaginationCriteria($page),
            new AllPlacePhotosCriteria(),
            new LatestReviewForPlaceCriteria(),
            ...$criterias
        );

        Redis::set('search_places-' . $uniqId, serialize($places));
        if (! $this->hasFilterParameters($request)) {
            Redis::setex('search_places-' . $uniqId, 1800, serialize($places));
        }

        return new GetPlaceCollectionResponse($places, $user);
    }

    private function generateUniqKeyByPlaceSearch(GetPlaceCollectionByFiltersRequest $request)
    {
        $baseRequest = [
            $request->getPage(),
            $request->getCategoryId(),
            $request->getLocation(),
            $request->getName()
        ];
        return implode('_', $baseRequest);
    }

    private function hasFilterParameters(GetPlaceCollectionByFiltersRequest $request)
    {
        $fPolygon = $request->getPolygon();
        $fTopReviewed = $request->isTopReviewed();
        $fTopRated = $request->isTopRated();
        $fCheckin = $request->isCheckin();
        $fSaved = $request->isSaved();
        return $fPolygon || $fTopReviewed || $fTopRated || $fCheckin || $fSaved;
    }
}