<?php

namespace Hedonist\Entities\Place;

use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Entities\Like\Like;
use Hedonist\Entities\Localization\PlaceTranslation;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\Taste;
use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hedonist\Entities\Place\Scope\PlaceScope;
use Sleimanx2\Plastic\Searchable;

class Place extends Model
{
    use SoftDeletes;
    use Searchable;

    protected $fillable = [
        'longitude',
        'latitude',
        'zip',
        'address',
        'phone',
        'website',
        'creator_id',
        'category_id',
        'city_id',
    ];

    protected $dates = ['deleted_at'];

    public $documentType = 'places';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PlaceScope);
    }

    public function placeInfo()
    {
        return $this->hasOne(PlaceInfo::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(PlaceCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'place_tag',
            'place_id',
            'tag_id'
        );
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function photos()
    {
        return $this->hasMany(PlacePhoto::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function tastes()
    {
        return $this->belongsToMany(
            Taste::class,
            'place_tastes'
        );
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'reviews');
    }

    public function ratings()
    {
        return $this->hasMany(PlaceRating::class);
    }

    public function lists()
    {
        return $this->belongsToMany(
            UserList::class,
            'user_list_places',
            'place_id',
            'list_id'
        );
    }

    public function features()
    {
        return $this->belongsToMany(PlaceFeature::class, 'places_places_features');
    }

    public function worktime()
    {
        return $this->hasMany(PlaceWorkTime::class);
    }

    public function setLocation(Location $location): void
    {
        $this->latitude = $location->getLatitude();
        $this->longitude = $location->getLongitude();
    }

    public function getLocation() : Location
    {
        return new Location(
            $this->longitude,
            $this->latitude
        );
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function dislikes()
    {
        return $this->morphMany(Dislike::class, 'dislikeable');
    }

    public function localization()
    {
        return $this->hasMany(PlaceTranslation::class);
    }

    public function buildDocument()
    {
        return [
            'id' => $this->id,
            'location' => [
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
            ],
            'zip' => $this->zip,
            'address' => $this->address,
            'phone' => $this->phone,
            'website' => $this->website,
            'creator_id' => $this->creator_id,
            'creator' => $this->creator,
            'category_id' => $this->category_id,
            'category' => $this->category,
            'city_id' => $this->city_id,
            'city' => $this->city,
            'info' => $this->placeInfo,
            'tags' => $this->tags,
            'photos' => $this->photos,
            'tastes' => $this->tastes,
            'reviews' => $this->reviews,
            'ratings' => $this->ratings,
            'features' => $this->features,
            'worktime' => $this->worktime,
            'localization' => $this->localization
        ];
    }
}
