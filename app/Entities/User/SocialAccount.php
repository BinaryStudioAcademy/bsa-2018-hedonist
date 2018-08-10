<?php

namespace Hedonist\Entities\User;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = ['user_id','provider','provider_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}