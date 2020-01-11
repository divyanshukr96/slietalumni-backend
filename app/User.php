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
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static create(array $data)
 * @method static find(int $id)
 * @method static role(string $string)
 * @method static latest()
 * @method static isAlumni()
 * @method static whereUsername($username)
 * @method static whereEmail($email)
 */
class User extends Authenticatable implements HasMedia, Auditable
{

    use HasApiTokens, Notifiable, HasRoles, UsesUuid, SoftDeletes, HasMediaTrait;
    use \OwenIt\Auditing\Auditable;

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
     * @return HasMany
     */
    public function alumniMeet()
    {
        return $this->hasMany(AlumniMeet::class);
    }

    /**
     * @param $profile
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
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


    /**
     * @return Mix|null
     */
    public function getProfileThumbAttribute()
    {
        $file = $this->getMedia('profile')->last();
        return $file ? $file->getUrl('thumb') : null;
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

    protected $casts = [
        'is_alumni' => 'boolean',
        'active' => 'boolean',
    ];

}
