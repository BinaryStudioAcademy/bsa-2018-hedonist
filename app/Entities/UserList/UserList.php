<?php

namespace Hedonist\Entities\UserList;

use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_lists';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','img_url'];
    /**
     * Get the user that owns the list.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * The places that belong to the list
     */
    public function places()
    {
        return $this->belongsToMany(Place::class);
    }
}
