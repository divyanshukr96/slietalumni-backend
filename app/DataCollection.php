<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static create(array $all)
 * @method static find($id)
 * @method static findOrFail($id)
 */
class DataCollection extends Model implements HasMedia
{
    use SoftDeletes, UsesUuid, HasMediaTrait;

    protected $fillable = ['name', 'email', 'mobile', 'profile', 'image'];

//    protected $fillable = ['name', 'email', 'mobile', 'programme', 'batch', 'branch', 'passing', 'organisation', 'designation'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderCreate', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
    }

    /**
     * @return MorphOne
     */
    public function academic()
    {
        return $this->morphOne(Academic::class, 'academicable');
    }

    /**
     * @return MorphOne
     */
    public function professional()
    {
        return $this->morphOne(Professional::class, 'professionalable');
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(preg_replace('/\s+/', ' ', $value));
    }

    /**
     * @param $image
     */
    public function setImageAttribute($image)
    {
        $this->addMedia($image)->toMediaCollection('data_collection');
    }

    /**
     * @param $image
     * @return mixed
     */
    public function getImageAttribute($image)
    {
        return $this->getMedia('data_collection')->last();
    }

}
