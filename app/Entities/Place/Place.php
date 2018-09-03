<?php

namespace Hedonist\Entities\Place;

use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Entities\Like\Like;
use Hedonist\Entities\Localization\PlaceTranslation;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hedonist\Entities\Place\Scope\PlaceScope;

class Place extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "longitude",
        "latitude",
        "zip",
        "address",
        "phone",
        "website",
        "creator_id",
        "category_id",
        "city_id",
    ];

    protected $dates = ['deleted_at'];

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
}
