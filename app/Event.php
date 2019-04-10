<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class Event extends Model
{
    protected $fillable = ['description', 'venue', 'date', 'time', 'image_id'];

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

}
