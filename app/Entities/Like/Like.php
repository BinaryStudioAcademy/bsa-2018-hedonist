<?php

namespace Hedonist\Entities\Like;

use Hedonist\Entities\User\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
