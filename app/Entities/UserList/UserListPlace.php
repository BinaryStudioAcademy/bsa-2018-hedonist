<?php

namespace Hedonist\Entities\UserListPlace;

use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\UserList\UserList;

class UserListPlace extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_list_places';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $timestamps = false;
    /**
     * Get the list that owns the list.
     */
    public function userList()
    {
        return $this->belongsTo(UserList::class);
    }
    /**
     * The place from list
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
