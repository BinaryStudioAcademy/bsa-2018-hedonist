<?php

namespace Hedonist\Entities\Review;

use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Entities\Like\Like;
use Hedonist\Entities\Like\LikeStatus;
use Hedonist\Entities\Review\Scopes\ReviewRelationScope;
use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;
use Sleimanx2\Plastic\Searchable;

class Review extends Model
{
    use Searchable;

    protected $table = 'reviews';

    protected $fillable = ['user_id', 'description', 'place_id'];

    public $documentIndex = 'reviews';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ReviewRelationScope());
    }

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

    private function isLiked(?int $userId): bool
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

    private function isDisliked(?int $userId): bool
    {
        if (is_null($userId)) {
            return false;
        }
        return !is_null($this->dislikes->first(
            function (Dislike $dislike) use ($userId) {
                return $dislike->user_id === $userId;
            })
        );
    }

    public function getLikedStatus(?int $userId): LikeStatus
    {
        if ($this->isLiked($userId)) {
            return LikeStatus::liked();
        }
        if ($this->isDisliked($userId)) {
            return LikeStatus::disliked();
        }

        return LikeStatus::none();
    }

    public function buildDocument()
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'place' => $this->place,
            'user' => $this->user,
            'photos' => $this->photos,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
        ];
    }
}