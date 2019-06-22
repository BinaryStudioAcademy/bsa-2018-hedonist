<?php

namespace Hedonist\Actions\Presenters\Review;

use Hedonist\Actions\Presenters\Category\CategoryPresenter;
use Hedonist\Actions\Presenters\City\CityPresenter;
use Hedonist\Actions\Presenters\Localization\LocalizationPresenter;
use Hedonist\Actions\Presenters\Photo\PlacePhotoPresenter;
use Hedonist\Actions\Presenters\Photo\ReviewPhotoPresenter;
use Hedonist\Actions\Presenters\PresentsCollection;
use Hedonist\Actions\Presenters\User\UserPresenter;
use Hedonist\Entities\Review\Review;
use Illuminate\Support\Collection;

class ReviewPresenter
{
    use PresentsCollection;

    private $usersPresenter;
    private $cityPresenter;
    private $categoryPresenter;
    private $placePhotoPresenter;
    private $reviewPhotoPresenter;
    private $localizationPresenter;

    public function __construct(
        UserPresenter $presenter,
        CityPresenter $cityPresenter,
        CategoryPresenter $categoryPresenter,
        PlacePhotoPresenter $photoPresenter,
        LocalizationPresenter $localizationPresenter,
        ReviewPhotoPresenter $reviewPhotoPressenter
    ) {
        $this->usersPresenter = $presenter;
        $this->cityPresenter = $cityPresenter;
        $this->categoryPresenter = $categoryPresenter;
        $this->placePhotoPresenter = $photoPresenter;
        $this->localizationPresenter = $localizationPresenter;
        $this->reviewPhotoPresenter = $reviewPhotoPressenter;
    }

    public function present(Review $review): array
    {
        return [
            'id' => $review->id,
            'created_at' => is_string($review->created_at) ? $review->created_at :  $review->created_at->format('Y-m-d H:i:s'),
            'description' => $review->description,
            'user' => $this->usersPresenter->present($review->user),
            'like' => $review->like_status,
            'likes' => $review->likes->count(),
            'dislikes' => $review->dislikes->count(),
            'photos' => $this->reviewPhotoPresenter->presentCollection($review->photos),
            'place_id' => $review->place_id,
            'user_id' => $review->user_id
        ];
    }

    public function presentCollectionWithPlace(Collection $collection): array
    {
        return $collection->map(function (Review $review) {
            $result = $this->present($review);
            $result['place_id'] = $review->place_id;
            $result['place']['photo']['img_url'] = '';
            if (!empty($review->place->photos)) {
                $result['place']['photo'] = $this->placePhotoPresenter->present($review->place->photos[0]);
            }
            $result['place']['city'] = $this->cityPresenter->present($review->place->city);
            $result['place']['localization'] = $this->localizationPresenter->presentCollection($review->place->localization);
            $result['place']['category'] = $this->categoryPresenter->present($review->place->category);
            $result['place']['rating'] = number_format(round($review->place->ratings->avg('rating'), 1), 1);

            return $result;
        })->toArray();
    }
}