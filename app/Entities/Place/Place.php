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

/**
 * Class Place
 *
 * @property int $id
 * @property float $longitude
 * @property float $latitude
 * @property int $zip
 * @property string $address
 * @property string $phone
 * @property string $website
 * @property int $creator_id
 * @property int $category_id
 * @property int $city_id
 * @property int $updated_at
 * @property int $created_at
 * @property int $deleted_at
 */
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

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(PlaceCategory::class);
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
        return $this->belongsToMany(UserList::class, 'user_list_places');
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
