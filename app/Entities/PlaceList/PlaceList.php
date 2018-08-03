<?php

namespace Hedonist\Entities\PlaceList;

use Illuminate\Database\Eloquent\Model;

class PlaceList extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lists';
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
