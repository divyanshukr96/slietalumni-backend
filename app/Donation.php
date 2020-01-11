<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property mixed verified_by
 * @property bool verified
 * @property bool verified_at
 * @property mixed verifyBy
 */
class Donation extends Model implements HasMedia, Auditable
{

    use SoftDeletes, UsesUuid, HasMediaTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'email', 'mobile', 'organisation', 'designation', 'category', 'amount', 'receipt', 'member'];


    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return BelongsTo
     */
    public function verifyBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }


    /**
     * @param $receipt
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setReceiptAttribute($receipt)
    {
        $this->addMedia($receipt)->toMediaCollection('donation');
    }


    /**
     * @return string
     */
    public function getReceiptAttribute()
    {
        return $this->getFirstMediaUrl('donation');
    }



    protected $casts = [
        'verified' => 'boolean',
    ];

}
