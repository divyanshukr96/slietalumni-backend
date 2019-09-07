<?php

namespace App;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @method static create(array $all)
 * @property mixed published_by
 * @property bool published
 * @property static published_at
 */
class Event extends Model implements HasMedia
{
    use UsesUuid, SoftDeletes, HasMediaTrait;

    protected $fillable = ['title', 'description', 'venue', 'date', 'time', 'image', 'content'];


    /**
     * @return BelongsTo
     */
    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    /**
     * @param $value
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * @param $value
     */
    public function setTimeAttribute($value)
    {
        $this->attributes['time'] = Carbon::parse($value)->format('H:i');
    }

    /**
     * @param $image
     */
    public function setImageAttribute($image)
    {
        $this->addMedia($image)->toMediaCollection();
    }

    /**
     * @return Collection
     */
    public function getImageAttribute()
    {
        $data = $this->getMedia()->last();
        return $data ? $data->getUrl() : null;
    }


    /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null)
    {
        try {
            $this->addMediaConversion('card')
                ->width(368)
                ->height(232);
        } catch (InvalidManipulation $e) {
        }
    }

}
