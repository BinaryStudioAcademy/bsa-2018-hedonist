<?php

namespace Hedonist\Entities\Dislike;

use Hedonist\Entities\User\User;
use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    protected $table = 'dislikes';

    protected $fillable = [
        'dislikeable_id',
        'dislikeable_type',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
