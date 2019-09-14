<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Str;

/**
 * @method static create(array $all)
 * @method static latest()
 * @method static wherePublished(bool $true)
 * @property bool published
 * @property mixed published_by
 * @property string published_at
 */
class News extends Model implements HasMedia
{
    use UsesUuid, SoftDeletes, HasMediaTrait;

    protected $fillable = ['title', 'description', 'content', 'social_link', 'cover'];


    /**
     * @param $image
     */
    public function setCoverAttribute($image)
    {
        $this->addMedia($image)->toMediaCollection('cover');
    }

    /**
     * @return mixed
     */
    public function getCoverAttribute()
    {
        $cover = $this->getMedia('cover')->last();
        return $cover ? $cover->getUrl() : null;
    }


    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Str::ucfirst($value);
    }


    /**
     * @return BelongsTo
     */
    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
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
