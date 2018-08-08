<?php

namespace Hedonist\Entities\User;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'phone_number',
        'avatar_url',
        'facebook_url',
        'instagram_url',
        'twitter_url',
    ];

    public function user()
    {
        return $this->belongsTo('user_id');
    }
}
