<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Actions\Presenters\Category\CategoryPresenter;
use Hedonist\Actions\Presenters\City\CityPresenter;
use Hedonist\Actions\Presenters\Localization\LocalizationPresenter;
use Hedonist\Actions\Presenters\Photo\PlacePhotoPresenter;
use Hedonist\Actions\Presenters\Place\PlacePresenter;
use Hedonist\Entities\Place\Checkin;
use Hedonist\Entities\Place\RatingAverage;
use Illuminate\Support\Collection;

class GetUserCheckInCollectionPresenter
{
    private $placePresenter;
    private $cityPresenter;
    private $categoryPresenter;
    private $localizationPresenter;
    private $photoPresenter;

    public function __construct(
        PlacePresenter $placePresenter,
        LocalizationPresenter $localizationPresenter,
        CityPresenter $cityPresenter,
        CategoryPresenter $categoryPresenter,
        PlacePhotoPresenter $photoPresenter
    ) {
        $this->placePresenter = $placePresenter;
        $this->cityPresenter = $cityPresenter;
        $this->categoryPresenter = $categoryPresenter;
        $this->localizationPresenter = $localizationPresenter;
        $this->photoPresenter = $photoPresenter;
    }

    public function present(GetUserCheckInCollectionResponse $checkInCollectionResponse): array
    {
        $checkInsArray = [];

        foreach ($checkInCollectionResponse->getPlaceCollection() as $checkIn) {
            $filteredRating = $checkInCollectionResponse
                ->getRatingCollection()
                ->first(function (RatingAverage $rating) use ($checkIn) {
                    return $rating->getPlaceId() === $checkIn->place->id;
                });
            $rating = $filteredRating ? $filteredRating->getAvgRating() : 0;
            $checkInsArray[] = $this->presentCollectionItem($checkIn, $rating);
        }

        return $checkInsArray;
    }

    public function presentCollectionItem(Checkin $checkIn, float $rating)
    {
        $checkInArray = [
            'id'        => $checkIn->id,
            'createdAt' => $checkIn->created_at->toDateTimeString(),
        ];
        $checkInArray['place'] = $this->placePresenter
            ->withRating($rating)
            ->present($checkIn->place);
        $checkInArray['place']['city'] = $this->cityPresenter
            ->present($checkIn->place->city);
        $checkInArray['place']['category'] = $this->categoryPresenter
            ->present($checkIn->place->category);
        $checkInArray['place']['localization'] = $this->localizationPresenter
            ->presentCollection($checkIn->place->localization);
        $checkInArray['place']['photos'] = $this->photoPresenter
            ->presentCollection($checkIn->place->photos);
        $checkInArray['place']['checkin_count'] = $checkIn->place->checkin_count;
        $checkInArray['place']['user_lists'] = $this->presentLists($checkIn->place->user_lists);

        return $checkInArray;
    }

    private function presentLists(Collection $lists) : array
    {
        $array = [];

        foreach ($lists as $list)
        {
            $array[] = [
                'id' => $list->id,
                'user_id' => $list->user_id,
                'name' => $list->name,
                'img_url' => $list->img_url,
            ];
        }

        return $array;
    }
}