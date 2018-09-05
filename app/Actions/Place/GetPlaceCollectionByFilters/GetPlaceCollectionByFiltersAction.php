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
use Illuminate\Support\Facades\Log;

class GetPlaceCollectionByFiltersAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceCollectionByFiltersRequest $request): GetPlaceCollectionResponse
    {
        $categoryId = $request->getCategoryId();
        $name = $request->getName();
        $location = $request->getLocation();
        $page = $request->getPage() ?: GetPlaceCollectionByFiltersRequest::DEFAULT_PAGE;
        $polygon = $request->getPolygon();
        $tags = $request->getTags();
        $features = $request->getFeatures();
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

        $filterInfo = $this->getPlaceFilterInfoJson($user, $request);
        Log::info("User has performed search: {$filterInfo}");
        return new GetPlaceCollectionResponse($places, $user);
    }

    private function getPlaceFilterInfoJson(User $user, GetPlaceCollectionByFiltersRequest $request): string
    {
        $info = [
            'userId' => $user->id
        ];

        $userInfo = $user->info;
        if (!is_null($userInfo)) {
            $info['name'] = "{$userInfo->first_name} {$userInfo->last_name}";
        }

        $filters = $request->getActiveFiltersArray();
        $info += $filters;

        return json_encode($info);
    }
}