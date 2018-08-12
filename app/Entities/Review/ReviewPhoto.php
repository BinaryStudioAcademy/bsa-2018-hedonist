<?php

namespace Hedonist\Entities\Review;

use Illuminate\Database\Eloquent\Model;

class ReviewPhoto extends Model
{
    public $timestamps = false;

    protected $table = 'review_photos';

    protected $fillable = ['img_url', 'description', 'review_id'];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
