<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class News extends Model
{
    protected $fillable = ['title', 'content', 'social_link'];

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

}
