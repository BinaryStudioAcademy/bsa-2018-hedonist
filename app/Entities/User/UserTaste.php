<?php

namespace Hedonist\Entities\User;

use Illuminate\Database\Eloquent\Model;

class UserTaste extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        $this->belongsToMany(User::class, 'users_user_tastes');
    }
}
