<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Actions\Place\GetPlaceRating\GetPlaceRatingResponse;
use Hedonist\Actions\Presenters\Review\ReviewPresenter;
use Hedonist\Actions\Presenters\Category\CategoryPresenter;
use Hedonist\Actions\Presenters\Category\Tag\CategoryTagPresenter;
use Hedonist\Actions\Presenters\City\CityPresenter;
use Hedonist\Actions\Presenters\Feature\FeaturePresenter;
use Hedonist\Actions\Presenters\Localization\LocalizationPresenter;
use Hedonist\Actions\Presenters\Photo\PlacePhotoPresenter;
use Hedonist\Actions\Presenters\Place\PlaceInfoPresenter;
use Hedonist\Actions\Presenters\Place\PlacePresenter;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\User;
use Illuminate\Support\Collection;

class GetPlaceItemPresenter
{
    private $placePresenter;
    private $reviewPresenter;
    private $localizationPresenter;
    private $cityPresenter;
    private $featurePresenter;
    private $categoryPresenter;
    private $photoPresenter;
    private $tagsPresenter;
    private $placeInfoPresenter;

    public function __construct(
        PlacePresenter $placePresenter,
        PlaceInfoPresenter $placeInfoPresenter,
        ReviewPresenter $reviewPresenter,
        LocalizationPresenter $localizationPresenter,
        CityPresenter $cityPresenter,
        FeaturePresenter $featurePresenter,
        CategoryPresenter $categoryPresenter,
        CategoryTagPresenter $tagsPresenter,
        PlacePhotoPresenter $photoPresenter
    ) {
        $this->placePresenter = $placePresenter;
        $this->placeInfoPresenter = $placeInfoPresenter;
        $this->reviewPresenter = $reviewPresenter;
        $this->localizationPresenter = $localizationPresenter;
        $this->cityPresenter = $cityPresenter;
        $this->featurePresenter = $featurePresenter;
        $this->categoryPresenter = $categoryPresenter;
        $this->tagsPresenter = $tagsPresenter;
        $this->photoPresenter = $photoPresenter;
    }

    public function present(GetPlaceItemResponse $placeResponse): array
    {
        $place = $placeResponse->getPlace();
        $result = $this->placePresenter->present($place);
        $result['placeInfo'] = $this->placeInfoPresenter->present($place->placeInfo);
        $result['reviews'] = $this->presentReviews($place->reviews, $placeResponse->getUser());
        $result['photos'] = $this->photoPresenter->presentCollection($place->photos);
        $result['city'] = $this->cityPresenter->present($place->city);
        $result['features'] = $this->featurePresenter->presentCollection($place->features);
        $result['localization'] = $this->localizationPresenter->presentCollection($place->localization);
        $result['category'] = $this->categoryPresenter->present($place->category);
        $result['category']['tags'] = $this->tagsPresenter->presentCollection($place->category->tags);

        return $result;
    }

    public function presentWithUserRating(GetPlaceItemResponse $placeResponse, ?float $userRating): array
    {
        $result = $this->present($placeResponse);
        $result['myRating'] = $userRating;

        return $result;
    }

    private function presentReviews(Collection $reviews, User $user): array
    {
        return $reviews->map(function (Review $item) use ($user) {
            $presented = $this->reviewPresenter->present($item);
            $presented['like'] = $item->getLikedStatus($user->id)->value();
            return $presented;
        })->toArray();
    }
}