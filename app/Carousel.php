<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static whereActive(bool $true)
 * @method static latest()
 * @method static create(array $validated)
 * @property mixed active
 */
class Carousel extends Model implements HasMedia, Auditable
{
    use SoftDeletes, UsesUuid, HasMediaTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['active', 'image'];

    /**
     * @param $image
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
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


    protected $casts = [
        'active' => 'boolean',
    ];

}
