<?php

namespace App;

use App\Traits\StoreImage;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $validated)
 */
class Donation extends Model
{

    use SoftDeletes, UsesUuid, StoreImage;

    protected $fillable = ['name', 'email', 'mobile', 'organisation', 'designation', 'category', 'amount', 'receipt', 'member'];


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
    public function setReceiptAttribute($value)
    {
        if (is_object($value)) {
            $value = $this->generateFileNameAndStore($value, '', true);
        }
        $this->attributes['receipt'] = $value;
    }

}
