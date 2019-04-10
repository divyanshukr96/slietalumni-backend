<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Image extends Model
{
    use StoreImage;

    protected $fillable = ['image'];


    public function setImageAttribute($image)
    {
        if (is_object($image)) {
            $image = $this->generateFileNameAndStore($image, '', true);
        }
        $this->attributes['image'] = $image;
    }


    public function news()
    {
        $this->belongsToMany('App\News');
    }

    public function blog()
    {
        $this->belongsToMany('App\Blog');
    }

}
