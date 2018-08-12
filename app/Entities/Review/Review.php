<?php

namespace Hedonist\Entities\Review;

use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = ['user_id', 'description', 'place_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function photos()
    {
        return $this->hasMany(ReviewPhoto::class);
    }
}