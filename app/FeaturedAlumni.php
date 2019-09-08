<?php

namespace App;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static latest()
 * @method static create(array $validated)
 */
class FeaturedAlumni extends Model implements HasMedia
{
    use UsesUuid, SoftDeletes, HasMediaTrait;

    protected $fillable = ['name', 'email', 'mobile', 'organisation', 'designation', 'image', 'featured'];


    public function alumni()
    {
        return $this->belongsTo(User::class,'alumni_id');
    }


    /**
     * @param $value
     */
    public function setFeaturedAttribute($value)
    {
        $this->attributes['featured'] = Carbon::parse($value)->format('Y-m-d');
    }


    /**
     * @param $image
     */
    public function setImageAttribute($image)
    {
        $this->addMedia($image)->toMediaCollection();
    }


    /**
     * @return mixed
     */
    public function getImageAttribute()
    {
        return $this->getMedia()->last();
    }

}
