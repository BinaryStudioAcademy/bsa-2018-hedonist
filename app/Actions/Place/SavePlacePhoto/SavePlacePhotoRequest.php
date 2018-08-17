<?php

namespace Hedonist\Actions\Place\SavePlacePhoto;

use Illuminate\Http\UploadedFile;

class SavePlacePhotoRequest
{
    private $id;
    private $description;
    private $img;
    private $creator_id;
    private $place_id;

    public function __construct(int $place_id, string $description, int $creator_id, UploadedFile $img, int $id = null)
    {
        $this->id = $id;
        $this->description = $description;
        $this->img = $img;
        $this->creator_id = $creator_id;
        $this->place_id = $place_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImg(): UploadedFile
    {
        return $this->img;
    }

    public function getPlaceId(): int
    {
        return $this->place_id;
    }

    public function getCreatorId(): int
    {
        return $this->creator_id;
    }
}