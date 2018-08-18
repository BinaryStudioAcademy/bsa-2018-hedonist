<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Actions\Place\Presenters\Review\ReviewPresenter;
use Hedonist\Actions\Presenters\Category\CategoryPresenter;
use Hedonist\Actions\Presenters\Category\Tag\CategoryTagPresenter;
use Hedonist\Actions\Presenters\City\CityPresenter;
use Hedonist\Actions\Presenters\Feature\FeaturePresenter;
use Hedonist\Actions\Presenters\Localization\LocalizationPresenter;
use Hedonist\Actions\Presenters\Photo\PlacePhotoPresenter;
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

    public function __construct(
        PlacePresenter $placePresenter,
        ReviewPresenter $reviewPresenter,
        LocalizationPresenter $localizationPresenter,
        CityPresenter $cityPresenter,
        FeaturePresenter $featurePresenter,
        CategoryPresenter $categoryPresenter,
        CategoryTagPresenter $tagsPresenter,
        PlacePhotoPresenter $photoPresenter
    )
    {
        $this->placePresenter = $placePresenter;
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
        $result['reviews'] = $this->presentReviews($place->reviews, $placeResponse->getUser());
        $result['photos'] = $this->photoPresenter->presentCollection($place->photos);
        $result['city'] = $this->cityPresenter->present($place->city);
        $result['features'] = $this->featurePresenter->presentCollection($place->features);
        $result['localization'] = $this->localizationPresenter->presentCollection($place->localization);
        $result['category'] = $this->categoryPresenter->present($place->category);
        $result['category']['tags'] = $this->tagsPresenter->presentCollection($place->category->tags);

        return $result;
    }

    private function presentReviews(Collection $reviews, User $user): array
    {
        return $reviews->map(function (Review $item) use ($user) {
            $presented = $this->reviewPresenter->present($item);
            $presented['like'] = $item->getLikedStatus($user->id);
            return $presented;
        })->toArray();
    }
}