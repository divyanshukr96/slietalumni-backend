<?php

namespace App;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @method static create(array $validateDta)
 * @method notify(Notifications\MeetRegistration $param)
 * @method static latest()
 * @property mixed name
 * @property mixed family
 * @property mixed fees
 */
class AlumniMeet extends Model implements Auditable
{
    use UsesUuid, SoftDeletes, Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name', 'email', 'mobile',
        'programme', 'branch', 'passing', 'batch',
        'organisation', 'designation',
        'family', 'accommodation', 'requirements',
    ];


    /**
     * @param $data
     * @return int
     */
    private static function fees($data)
    {
        if ($data->family) {
            return 3500; // Alumni Meet Registration fees with family
        }
        return 2500; // Alumni Meet Registration fees
    }


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->year = Carbon::now()->year;
            $query->fees = self::fees($query);
        });
    }

    /**
     * @return BelongsTo
     */
    public function alumni()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * @return MorphOne
     */
    public function payment()
    {
        return $this->morphOne(PaymentReceipt::class, 'paymentable');
    }

}
