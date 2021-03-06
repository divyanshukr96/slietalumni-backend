<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static create(array $all)
 * @method static where(string $string, $email)
 * @method static latest()
 * @method notify(Notifications\RegistrationSuccess | Notifications\RegistrationConfirmation $param)
 * @property bool verified
 * @property mixed email
 * @property mixed verified_by
 * @property mixed payment
 * @property static verified_at
 * @property mixed name
 */
class Registration extends Model implements HasMedia, Auditable
{
    use SoftDeletes, UsesUuid, HasMediaTrait, Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'email', 'mobile', 'programme', 'branch', 'passing', 'batch', 'organisation', 'designation', 'image', 'linkdein'];

    /**
     * @param $value
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setImageAttribute($value)
    {
        $this->addMedia($value)->toMediaCollection();
    }

    /**
     * @return mixed
     */
    public function getImageAttribute()
    {
        return $this->getMedia()->first();
    }

    /**
     * @return mixed
     */
    public function getImageUrlAttribute()
    {
        $data = $this->getMedia()->first();
        if ($data) return $data->getUrl();

        return $data;
    }

    /**
     * @return MorphOne
     */
    public function payment()
    {
        return $this->morphOne(PaymentReceipt::class, 'paymentable');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $value
     */
    public function setVerifiedByAttribute($value)
    {
        $this->attributes['user_id'] = $value;
    }

    /**
     * @return Model|BelongsTo|object|null
     */
    public function getVerifiedByAttribute()
    {
        return $this->user()->first();
    }


    protected $casts = [
        'verified' => 'boolean',
    ];

}
