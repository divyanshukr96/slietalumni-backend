<?php

namespace App;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @method static latest()
 * @method static create(array $validated)
 * @method static whereDate(string $string, string $string1, string $toDateString)
 */
class FeaturedAlumni extends Model implements HasMedia
{
    use UsesUuid, SoftDeletes, HasMediaTrait;

    protected $fillable = ['name', 'email', 'mobile', 'organisation', 'designation', 'image', 'featured'];


    public function alumni()
    {
        return $this->belongsTo(User::class, 'alumni_id');
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
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
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


    /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null)
    {
        try {
            $this->addMediaConversion('thumb')
                ->width(368)
                ->height(232);
        } catch (InvalidManipulation $e) {
        }
    }

}
