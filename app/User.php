<?php

namespace App;

use App\Traits\UsesUuid;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static create(array $data)
 * @method static find(int $id)
 * @method static role(string $string)
 * @method static latest()
 * @method static isAlumni()
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, UsesUuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'mobile', 'image_id', 'active'
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
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return HasMany
     */
    public function educations()
    {
        return $this->hasMany(Academic::class);
    }

    /**
     * @return HasMany
     */
    public function professional()
    {
        return $this->hasMany(ProfessionalDetails::class);
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = strlen($value) < 60 ? Hash::make($value) : $value;
    }

    /**
     * @return HasOne
     */
    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsAlumni(Builder $query): Builder
    {
        return $query->whereHas('alumni');
    }

}
