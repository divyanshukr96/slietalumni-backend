<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class PaymentReceipt extends Model implements HasMedia
{
    use SoftDeletes, UsesUuid, HasMediaTrait;

    protected $fillable = ['receipt', 'amount'];

    /**
     * @return MorphTo
     */
    public function paymentable()
    {
        return $this->morphTo();
    }

    public function setReceiptAttribute($receipt)
    {
        $this->addMedia($receipt)->toMediaCollection('payment_receipt');
    }

}
