<?php

namespace Hedonist\Actions\Place\AddPlace;

class AddPlaceRequest
{
    private $creatorId;
    private $localization;
    private $categoryId;
    private $tags;
    private $features;
    private $city;
    private $longitude;
    private $latitude;
    private $zip;
    private $address;
    private $phone;
    private $website;
    private $facebook;
    private $instagram;
    private $twitter;
    private $menu_url;
    private $work_weekend;
    private $photos;
    private $worktime;

    public function __construct(
        int $creatorId,
        String $localization,
        int $categoryId,
        array $tags,
        array $features,
        String $city,
        float $longitude,
        float $latitude,
        int $zip,
        string $address,
        string $phone,
        string $website,
        string $facebook,
        string $instagram,
        string $twitter,
        string $menu_url,
        int $work_weekend,
        ?array $photos,
        String $worktime
    ) {
        $this->creatorId = $creatorId;
        $this->localization = $localization;
        $this->categoryId = $categoryId;
        $this->tags = $tags;
        $this->features = $features;
        $this->city = $city;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->zip = $zip;
        $this->address = $address;
        $this->phone = $phone;
        $this->website = $website;
        $this->facebook = $facebook;
        $this->instagram = $instagram;
        $this->twitter = $twitter;
        $this->menu_url = $menu_url;
        $this->work_weekend = $work_weekend;
        $this->photos = $photos;
        $this->worktime = $worktime;
    }

    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    public function getLocalization(): array
    {
        return json_decode($this->localization, true);
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function getFeatures(): ?array
    {
        return $this->features;
    }

    public function getCity(): array
    {
        $cityObj = json_decode($this->city, true);
        return [
            'name' => $cityObj['text_en'],
            'lng'  => $cityObj['center'][0],
            'lat'  => $cityObj['center'][1],
        ];
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getZip(): int
    {
        return $this->zip;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getFacebook(): string
    {
        return $this->facebook;
    }

    public function getInstagram(): string
    {
        return $this->instagram;
    }

    public function getTwitter(): string
    {
        return $this->twitter;
    }

    public function getMenuUrl(): string
    {
        return $this->menu_url;
    }

    public function getWorkWeekend(): string
    {
        return $this->work_weekend;
    }

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function getWorktime(): array
    {
        return json_decode($this->worktime, true);
    }

    public function toArray(): array
    {
        return [
            'creator_id'    => $this->getCreatorId(),
            'localization'  => $this->getLocalization(),
            'category_id'   => $this->getCategoryId(),
            'tags'          => $this->getTags(),
            'features'      => $this->getFeatures(),
            'city'          => $this->getCity(),
            'longitude'     => $this->getLongitude(),
            'latitude'      => $this->getLatitude(),
            'zip'           => $this->getZip(),
            'address'       => $this->getAddress(),
            'phone'         => $this->getPhone(),
            'website'       => $this->getWebsite(),
            'facebook'      => $this->getFacebook(),
            'instagram'     => $this->getInstagram(),
            'twitter'       => $this->getTwitter(),
            'menu_url'      => $this->getMenuUrl(),
            'work_weekend'  => $this->getWorkWeekend(),
            'photos'        => $this->getPhotos(),
            'worktime'      => $this->getWorktime()
        ];
    }
}
