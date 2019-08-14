<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static where(string $string, $email)
 * @method static latest()
 * @property bool verified
 * @property mixed email
 */
class AlumniRegistration extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = ['name', 'email', 'mobile', 'programme', 'branch', 'passing', 'batch', 'organisation', 'designation', 'image', 'linkdein'];

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    public function setImageAttribute($value)
    {
        if (is_object($value)) $this->attributes['image_id'] = Image::create(['image' => $value])->id;
    }

}
