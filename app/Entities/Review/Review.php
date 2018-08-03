<?php

namespace Hedonist\Entities\Review;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reviews';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','description','place_id'];
    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the place 
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    /**
     * The review's photos
     */
    public function photos()
    {
        return $this->hasMany(ReviewPhoto::class);
    }
}
