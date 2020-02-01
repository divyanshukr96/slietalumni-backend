<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
class GalleryImage extends Model implements HasMedia, Auditable
{
    use HasMediaTrait;
    use UsesUuid, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['image', 'album'];


    /**
     * @return BelongsTo
     */
    public function album()
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id');
    }


    /**
     * @param $value
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setImageAttribute($value)
    {
        $this->addMedia($value)->toMediaCollection('gallery-image');
    }


    /**
     * @param $value
     */
    public function setAlbumAttribute($value)
    {
        $this->attributes['gallery_album_id'] = $value;
    }


    /**
     * @return mixed
     */
    public function getImageAttribute()
    {
        return $this->getMedia('gallery-image')->last();
//        return $file ? $file->getUrl('thumb') : null;
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
