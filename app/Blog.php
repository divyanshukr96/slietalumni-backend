<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static create(array $all)
 */
class Blog extends Model implements HasMedia
{
    use UsesUuid, HasMediaTrait;

    protected $fillable = ['title', 'content'];

//    public function images()
//    {
//        return $this->belongsToMany('App\Image');
//    }
}
