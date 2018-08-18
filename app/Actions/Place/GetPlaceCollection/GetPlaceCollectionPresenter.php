<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Actions\Place\Presenters\Review\ReviewPresenter;
use Hedonist\Actions\Presenters\Category\CategoryPresenter;
use Hedonist\Actions\Presenters\Category\Tag\CategoryTagPresenter;
use Hedonist\Actions\Presenters\City\CityPresenter;
use Hedonist\Actions\Presenters\Feature\FeaturePresenter;
use Hedonist\Actions\Presenters\Localization\LocalizationPresenter;
use Hedonist\Actions\Presenters\Photo\PlacePhotoPresenter;
use Hedonist\Actions\Presenters\Place\PlacePresenter;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;
use Illuminate\Support\Collection;

class GetPlaceCollectionPresenter
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
    ) {
        $this->placePresenter = $placePresenter;
        $this->reviewPresenter = $reviewPresenter;
        $this->localizationPresenter = $localizationPresenter;
        $this->cityPresenter = $cityPresenter;
        $this->featurePresenter = $featurePresenter;
        $this->categoryPresenter = $categoryPresenter;
        $this->tagsPresenter = $tagsPresenter;
        $this->photoPresenter = $photoPresenter;
    }

    public function present(GetPlaceCollectionResponse $placeResponse): array
    {
        return $placeResponse->getPlaceCollection()->map(function (Place $place) use ($placeResponse) {
            $result = $this->placePresenter->present($place);
            $result['review'] = $this->presentReview(
                $placeResponse->getReviews(),
                $place,
                $placeResponse->getUser()
            );
            $result['photos'] = $this->photoPresenter->presentCollection($place->photos);
            $result['city'] = $this->cityPresenter->present($place->city);
            $result['features'] = $this->featurePresenter->presentCollection($place->features);
            $result['localization'] = $this->localizationPresenter->presentCollection($place->localization);
            $result['category'] = $this->categoryPresenter->present($place->category);
            $result['category']['tags'] = $this->tagsPresenter->presentCollection($place->category->tags);

            return $result;
        })->toArray();
    }

    private function presentReview(Collection $reviews, Place $place, User $user): ?array
    {
        $review = $reviews->first(function ($item) use ($place) {
            return $place->id === $item->place_id;
        });
        if (is_null($review)) {
            return null;
        }
        $presented = $this->reviewPresenter->present($review);
        $presented['like'] = $review->getLikedStatus($user->id);
        return $presented;
    }
}