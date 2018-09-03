<?php

namespace Hedonist\Actions\Place\SavePlacePhoto;

use Illuminate\Http\UploadedFile;

class SavePlacePhotoRequest
{
    private $description;
    private $img;
    private $creator_id;
    private $place_id;

    public function __construct(int $place_id, string $description, int $creator_id, UploadedFile $img)
    {
        $this->description = $description;
        $this->img = $img;
        $this->creator_id = $creator_id;
        $this->place_id = $place_id;
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