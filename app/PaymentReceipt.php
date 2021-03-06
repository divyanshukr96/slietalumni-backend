<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Str;

class PaymentReceipt extends Model implements HasMedia, Auditable
{
    use SoftDeletes, UsesUuid, HasMediaTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['receipt', 'amount', 'mode', 'description'];

    /**
     * @return MorphTo
     */
    public function paymentable()
    {
        return $this->morphTo();
    }

    public function setModeAttribute($value)
    {
        $this->attributes['mode'] = Str::upper($value);
    }

    /**
     * @param $receipt
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setReceiptAttribute($receipt)
    {
        $this->addMedia($receipt)->toMediaCollection('payment_receipt');
    }


    protected $casts = [
        'verified' => 'boolean',
    ];

}
