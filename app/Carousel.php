<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static whereActive(bool $true)
 * @method static latest()
 * @method static create(array $validated)
 */
class Carousel extends Model implements HasMedia
{
    use SoftDeletes, UsesUuid, HasMediaTrait;

    protected $fillable = ['active', 'image'];

    /**
     * @param $image
     */
    public function setImageAttribute($image)
    {
        $this->addMedia($image)->toMediaCollection('carousel');
    }

    /**
     * @return mixed|null
     */
    public function getImageAttribute()
    {
        $data = $this->getMedia('carousel')->last();
        return $data ?: null;
    }

}
