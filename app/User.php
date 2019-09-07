<?php

namespace App;

use App\Traits\UsesUuid;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Mix;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static create(array $data)
 * @method static find(int $id)
 * @method static role(string $string)
 * @method static latest()
 * @method static isAlumni()
 * @method static whereUsername($username)
 */
class User extends Authenticatable implements HasMedia
{

    use HasApiTokens, Notifiable, HasRoles, UsesUuid, SoftDeletes, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'mobile', 'profile', 'active', 'is_alumni'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return MorphMany
     */
    public function academics()
    {
        return $this->morphMany(Academic::class, 'academicable');
    }

    /**
     * @return MorphMany
     */
    public function professionals()
    {
        return $this->morphMany(Professional::class, 'professionalable');
    }

    /**
     * @return HasMany
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $hash = Hash::info($value);
        $this->attributes['password'] = ($hash['algoName'] === Hash::getDefaultDriver()) ? $value : Hash::make($value);
    }

//    /**
//     * @return HasOne
//     * not required
//     */
//    public function alumni()
//    {
//        return $this->hasOne(Alumni::class);
//    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsAlumni(Builder $query): Builder
    {
        return $query->where('is_alumni', true);
    }

    /**
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * @param $profile
     */
    public function setProfileAttribute($profile)
    {
        $this->copyMedia($profile)->toMediaCollection('profile');
    }

    /**
     * @return Mix|null
     */
    public function getProfileAttribute()
    {
        $file = $this->getMedia('profile')->last();
        return $file ? $file->getUrl() : null;
    }
}
