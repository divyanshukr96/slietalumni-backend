<?php

namespace App;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static create(array $validated)
 * @method static latest()
 * @method static orderByRaw(string $string)
 * @property mixed user_id
 */
class Member extends Model implements HasMedia, Auditable
{


    use UsesUuid, SoftDeletes, HasMediaTrait;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = ['name', 'designation', 'from', 'to', 'image', 'sac', 'profile'];


    /**
     * @param $value
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setImageAttribute($value)
    {
        $this->addMedia($value)->toMediaCollection('member');
    }


    /**
     * @param $value
     */
    public function setFromAttribute($value)
    {
        $this->attributes['from'] = Carbon::parse($value)->format('Y-m-d');
    }


    /**
     * @param $value
     */
    public function setToAttribute($value)
    {
        $this->attributes['to'] = Carbon::parse($value)->format('Y-m-d');
    }


    /**
     * @param $value
     */
    public function setProfileAttribute($value)
    {
        try {
            $user_id = User::whereUsername($value)->first()->id;
            $this->attributes['user_id'] = $user_id;
        } catch (\Exception  $e) {

        }
    }


    public function getProfileAttribute()
    {
        return User::find($this->user_id);
    }


    protected $casts = [
        'sac' => 'boolean',
    ];

}
