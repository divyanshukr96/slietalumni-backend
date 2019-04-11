<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 */
class AlumniRegistration extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'mobile', 'programme', 'batch', 'branch', 'passing', 'organisation', 'designation', 'image'];

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    public function setImageAttribute($value)
    {
        if (is_object($value)) $this->attributes['image_id'] = Image::create(['image' => $value])->id;
    }

}
