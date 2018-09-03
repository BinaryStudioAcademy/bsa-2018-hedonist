<?php

namespace Hedonist\Actions\Review;

class GetReviewCollectionRequest
{
    private $page;
    private $placeId;
    private $sort;
    private $order;
    private $text;

    const DEFAULT_PAGE = 1;

    public function __construct(
        ?int $page,
        ?int $placeId,
        ?string $sort,
        ?string $order,
        ?string $text = ""
    ) {
        $this->page = $page;
        $this->placeId = $placeId;
        $this->sort = $sort;
        $this->order = $order;
        $this->text = $text;
    }

    public function getPlaceId(): ?int
    {
        return $this->placeId;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}
