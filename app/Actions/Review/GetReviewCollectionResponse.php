<?php

namespace Hedonist\Actions\Review;

use Illuminate\Support\Collection;

class GetReviewCollectionResponse
{
    private $reviewCollection;
    private $totalCount;
    private $perPage;

    public function __construct(Collection $reviews, int $totalCount, int $perPage)
    {
        $this->reviewCollection = $reviews;
        $this->totalCount = $totalCount;
        $this->perPage = $perPage;
    }

    public function getReviewCollection(): array
    {
        return $this->reviewCollection->toArray();
    }

    public function getPaginationMetaInfo(): array
    {
        return [
          'pagination' => [
              'perPage' => $this->perPage,
              'total' => $this->totalCount
          ]
        ];
    }
}
