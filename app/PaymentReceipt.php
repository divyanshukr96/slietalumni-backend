<?php

namespace App;

use App\Traits\StoreImage;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentReceipt extends Model
{
    use SoftDeletes, UsesUuid, StoreImage;

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
        if (is_object($receipt)) {
            $receipt = $this->generateFileNameAndStore($receipt, '', true);
        }
        $this->attributes['receipt'] = $receipt;
    }

}
