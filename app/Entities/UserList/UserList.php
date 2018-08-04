<?php

namespace Hedonist\Entities\UserList;

use Hedonist\User;
use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $table = 'user_lists';
    
    protected $fillable = ['user_id','name','img_url'];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
