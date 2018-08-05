<?php

namespace Hedonist\Entities;

use Hedonist\User;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $table = "likes";

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
