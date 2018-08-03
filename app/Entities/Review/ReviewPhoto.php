<?php

namespace Hedonist\Entities\Review;

use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\Review\Review;

class ReviewPhoto extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review_photos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['img_url','description','review_id'];
    /**
     * Get photo's review
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
