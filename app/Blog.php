<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class Blog extends Model
{
    protected $fillable = ['title', 'content'];

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }
}
