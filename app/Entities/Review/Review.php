<?php

namespace Hedonist\Entities\Review;

use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Entities\Like\Like;
use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Review\ReviewPhoto;

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

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function dislikes()
    {
        return $this->morphMany(Dislike::class, 'dislikeable');
    }

    public function isLiked(?int $userId): bool
    {
        if (is_null($userId)) {
            return false;
        }
        return !is_null($this->likes->first(
            function (Like $like) use ($userId) {
                return $like->user_id === $userId;
            })
        );
    }

    public function isDisliked(?int $userId): bool
    {
        if (is_null($userId)) {
            return false;
        }
        return !is_null($this->likes->first(
            function (Dislike $dislike) use ($userId) {
                return $dislike->user_id === $userId;
            })
        );
    }
}