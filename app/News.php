<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class News extends Model
{
    use UsesUuid;

    protected $fillable = ['title', 'content', 'social_link'];

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

}
