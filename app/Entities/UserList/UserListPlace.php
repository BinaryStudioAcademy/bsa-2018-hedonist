<?php

namespace Hedonist\Entities\UserList;

use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\UserList\UserList;
use Hedonist\Entities\Place\Place;

class UserListPlace extends Model
{
    protected $table = 'user_list_places';
    
    protected $fillable = ['list_id','place_id'];
   
    public function userList()
    {
        return $this->belongsTo(UserList::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
