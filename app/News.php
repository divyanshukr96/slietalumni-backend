<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

/**
 * @method static create(array $all)
 * @property bool publish
 */
class News extends Model
{
    use UsesUuid, SoftDeletes;

    protected $fillable = ['title', 'description', 'content', 'social_link', 'cover'];

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    /**
     * @return HasOne
     */
    public function covers()
    {
        return $this->hasOne('App\Image','id', 'cover');
    }

    /**
     * @param $value
     */
    public function setCoverAttribute($value)
    {
        $this->attributes['cover'] = Image::create(['image' => $value])->id;
    }

    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Str::ucfirst($value);
    }

}
