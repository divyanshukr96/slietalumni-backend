<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @method static create(array $validated)
 */
class GalleryAlbum extends Model implements HasMedia, Auditable
{
    use HasMediaTrait;
    use UsesUuid, SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = ['title', 'description', 'cover'];


    /**
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }


    /**
     * @param $value
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setCoverAttribute($value)
    {
        $this->addMedia($value)->toMediaCollection('album-cover');
    }


    public function getCoverAttribute()
    {
        $file = $this->getMedia('album-cover')->last();
        return $file ? $file->getUrl('thumb') : null;
    }

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->height(300);
    }

}
