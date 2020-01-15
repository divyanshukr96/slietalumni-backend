<?php

namespace App;

use App\Traits\UsesUuid;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static create(array $all)
 * @method static find($id)
 * @method static findOrFail($id)
 * @property mixed professional
 * @property mixed academic
 */
class DataCollection extends Model implements HasMedia, Auditable
{
    use SoftDeletes, UsesUuid, HasMediaTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'email', 'mobile', 'profile', 'image', 'extra'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderCreate', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
        self::creating(function ($query) {
            $query->created_by = Auth::user()->getAuthIdentifier();
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
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
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
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
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

    protected $casts = [
        'extra' => 'array'
    ];

}
