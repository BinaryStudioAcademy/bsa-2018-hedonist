<?php

namespace Hedonist\Entities\UserList;

use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\User\User;

class UserList extends Model
{
    protected $table = 'user_lists';
    
    protected $fillable = ['user_id','name','img_url'];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
