<?php

namespace Hedonist\Actions\UserList;

use Illuminate\Http\UploadedFile;

class SaveUserListRequest
{
    private $id;
    private $image;
    private $name;
    private $userId;
    private $attachedPlaces;

    public function __construct(
        int $userId,
        ?string $name,
        ?UploadedFile $image,
        ?array $attachedPlaces,
        int $id = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->image = $image;
        $this->attachedPlaces = $attachedPlaces;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAttachedPlaces(): ?array
    {
        return $this->attachedPlaces;
    }
}