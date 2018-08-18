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

    public function present(GetPlaceCollectionResponse $placeResponse): array
    {
        return $placeResponse->getPlaceCollection()->map(function ($place) use ($placeResponse) {
            $result = $this->placePresenter->present($place);
            $review = $placeResponse->getReviews()->first(function ($item) use ($place) {
                return $place->id === $item->place_id;
            });
            $result['review'] = $review ?
                $this->reviewPresenter->present($review) :
                null;
            $result['photos'] = $this->photoPresenter->presentCollection($place->photos);
            $result['city'] = $this->cityPresenter->present($place->city);
            $result['features'] = $this->featurePresenter->presentCollection($place->features);
            $result['localization'] = $place->localization->map(function ($localization) {
                return $this->localizationPresenter->present($localization);
            });
            $result['category'] = $this->categoryPresenter->present($place->category);
            $result['category']['tags'] = $place->category->tags->map(function ($tag) {
                return $this->tagsPresenter->present($tag);
            });

            return $result;
        })->toArray();
    }
}