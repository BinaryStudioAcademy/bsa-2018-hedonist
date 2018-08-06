<?php

namespace Hedonist\Entities\Place;

use Hedonist\User;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        "longitude",
        "latitude",
        "zip",
        "address",
        "creator_id",
        "category_id",
        "city_id",
    ];

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
        return $this->hasMany(Rating::class);
    }

    public function lists()
    {
        return $this->belongsToMany(UserList::class, 'user_list_places');
    }

    public function features()
    {
        return $this->belongsToMany(PlaceFeature::class, 'places_places_features');
    }
}
