<?php

namespace Hedonist\Http\Controllers\Api\Place;

use Hedonist\Actions\Place\AddPlace\AddPlaceAction;
use Hedonist\Actions\Place\AddPlace\AddPlacePresenter;
use Hedonist\Actions\Place\AddPlace\AddPlaceRequest;
use Hedonist\Actions\Place\AddPlaceTaste\AddPlaceTasteAction;
use Hedonist\Actions\Place\AddPlaceTaste\AddPlaceTasteRequest;
use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionAction;
use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionPresenter;
use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionRequest;
use Hedonist\Actions\Place\GetPlaceCollectionByFilters\GetPlaceCollectionByFiltersAction;
use Hedonist\Actions\Place\GetPlaceCollectionByFilters\GetPlaceCollectionByFiltersRequest;
use Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete\GetPlaceCollectionForAutoCompleteAction;
use Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete\GetPlaceCollectionForAutoCompleteRequest;
use Hedonist\Actions\Place\GetPlaceItem\GetPlaceItemAction;
use Hedonist\Actions\Place\GetPlaceItem\GetPlaceItemPresenter;
use Hedonist\Actions\Place\GetPlaceItem\GetPlaceItemRequest;
use Hedonist\Actions\Place\GetUserRatingForPlace\GetUserRatingForPlaceAction;
use Hedonist\Actions\Place\GetUserRatingForPlace\GetUserRatingForPlaceRequest;
use Hedonist\Actions\Place\GetUserRatingForPlace\GetUserRatingForPlaceResponse;
use Hedonist\Actions\Place\RemovePlace\RemovePlaceAction;
use Hedonist\Actions\Place\RemovePlace\RemovePlaceRequest;
use Hedonist\Actions\Place\UpdatePlace\UpdatePlaceAction;
use Hedonist\Actions\Place\UpdatePlace\UpdatePlacePresenter;
use Hedonist\Actions\Place\UpdatePlace\UpdatePlaceRequest;
use Hedonist\Exceptions\DomainException;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Exceptions\Place\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceCreatorDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceRatingNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Place\PlaceSearchRequest;
use Hedonist\Http\Requests\Place\PlaceTasteRequest;
use Hedonist\Http\Requests\Place\ValidateAddPlaceRequest;
use Hedonist\Http\Requests\Place\ValidateUpdatePlaceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends ApiController
{
    private $getPlaceCollectionAction;
    private $getPlaceItemAction;
    private $removePlaceAction;
    private $addPlaceAction;
    private $updatePlaceAction;
    private $getUserRatingForPlaceAction;
    private $getPlaceCollectionByFiltersAction;
    private $getPlaceCollectionForAutoCompleteAction;
    private $addPlaceTasteAction;

    public function __construct(
        GetPlaceItemAction $getPlaceItemAction,
        GetPlaceCollectionAction $getPlaceCollectionAction,
        RemovePlaceAction $removePlaceAction,
        AddPlaceAction $addPlaceAction,
        UpdatePlaceAction $updatePlaceAction,
        GetUserRatingForPlaceAction $getUserRatingForPlaceAction,
        GetPlaceCollectionByFiltersAction $getPlaceCollectionByFiltersAction,
        GetPlaceCollectionForAutoCompleteAction $getPlaceCollectionForAutoCompleteAction,
        AddPlaceTasteAction $addPlaceTasteAction
    ) {
        $this->getPlaceItemAction = $getPlaceItemAction;
        $this->getPlaceCollectionAction = $getPlaceCollectionAction;
        $this->removePlaceAction = $removePlaceAction;
        $this->addPlaceAction = $addPlaceAction;
        $this->updatePlaceAction = $updatePlaceAction;
        $this->getUserRatingForPlaceAction = $getUserRatingForPlaceAction;
        $this->getPlaceCollectionByFiltersAction = $getPlaceCollectionByFiltersAction;
        $this->getPlaceCollectionForAutoCompleteAction = $getPlaceCollectionForAutoCompleteAction;
        $this->addPlaceTasteAction = $addPlaceTasteAction;
    }

    public function getPlace(int $id, GetPlaceItemPresenter $presenter): JsonResponse
    {
        try {
            $placeResponse = $this->getPlaceItemAction->execute(new GetPlaceItemRequest($id));
            $placeRatingResponse = $this->getUserRatingForPlaceAction->execute(
                new GetUserRatingForPlaceRequest($id)
            );
        } catch (PlaceDoesNotExistException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        } catch (PlaceRatingNotFoundException $e) {
            $placeRatingResponse = null;
        }

        return $this->successResponse($presenter->presentWithUserRating(
            $placeResponse,
            $placeRatingResponse ? $placeRatingResponse->getRatingValue() : null
        ));
    }

    public function getCollection(Request $request, GetPlaceCollectionPresenter $presenter): JsonResponse
    {
        $placeResponse = $this->getPlaceCollectionByFiltersAction->execute(
            new GetPlaceCollectionByFiltersRequest(
                $request->input('page'),
                null,
                null,
                null,
                null,
                null
            )
        );
        return $this->successResponse($presenter->present($placeResponse));
    }

    public function removePlace(int $id): JsonResponse
    {
        try {
            $this->removePlaceAction->execute(new RemovePlaceRequest($id));
        } catch (PlaceDoesNotExistException $e) {
            return $this->emptyResponse(404);
        }

        return $this->emptyResponse(204);
    }

    public function addPlace(ValidateAddPlaceRequest $request): JsonResponse
    {
        try {
            $placeResponse = $this->addPlaceAction->execute(new AddPlaceRequest(
                $request->creator_id,
                $request->localization,
                $request->category_id,
                $request->city,
                $request->longitude,
                $request->latitude,
                $request->zip,
                $request->address,
                $request->phone,
                $request->website,
                $request->facebook,
                $request->instagram,
                $request->twitter,
                $request->menu_url,
                $request->work_weekend,
                $request->worktime,
                $request->tags,
                $request->features,
                $request->photos
            ));
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse(AddPlacePresenter::present($placeResponse), 201);
    }

    public function updatePlace(ValidateUpdatePlaceRequest $request): JsonResponse
    {
        try {
            $placeResponse = $this->updatePlaceAction->execute(new UpdatePlaceRequest(
                $request->id,
                $request->creator_id,
                $request->category_id,
                $request->city_id,
                $request->longitude,
                $request->latitude,
                $request->zip,
                $request->address,
                $request->phone,
                $request->website
            ));
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse(UpdatePlacePresenter::present($placeResponse), 201);
    }

    public function searchByFilters(PlaceSearchRequest $request, GetPlaceCollectionPresenter $presenter): JsonResponse
    {
        try {
            $placeResponse = $this->getPlaceCollectionByFiltersAction->execute(
                new GetPlaceCollectionByFiltersRequest(
                    $request->input('page'),
                    $request->input('filter.category'),
                    $request->input('filter.location'),
                    $request->input('filter.name'),
                    $request->input('filter.polygon'),
                    $request->input('filter.tags'),
                    $request->input('filter.features'),
                    $request->input('filter.top_reviewed'),
                    $request->input('filter.top_rated'),
                    $request->input('filter.checkin'),
                    $request->input('filter.saved')
                )
            );

            return $this->successResponse($presenter->present($placeResponse), 200);
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getCollectionForAutocomplete(PlaceSearchRequest $request, GetPlaceCollectionPresenter $presenter): JsonResponse
    {
        try {
            $placeResponse = $this->getPlaceCollectionForAutoCompleteAction->execute(
                new GetPlaceCollectionForAutoCompleteRequest(
                    $request->input('filter.name'),
                    $request->input('filter.location')
                )
            );

            return $this->successResponse($presenter->presentForAutoComplete($placeResponse), 200);
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function addTaste(PlaceTasteRequest $request): JsonResponse
    {
        try {
            $this->addPlaceTasteAction->execute(
                new AddPlaceTasteRequest(
                    $request->input('place_id'),
                    $request->input('taste_id')
                )
            );

            return $this->emptyResponse();
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
