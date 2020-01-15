<?php

namespace App;

use App\Traits\UsesUuid;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @method static create(array $validated)
 * @method static latest()
 * @method static whereDate(string $string, string $string1, string $toDateString)
 */
class PublicNotice extends Model implements Auditable
{
    use UsesUuid, SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = ['notice', 'notice_till'];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->user_id = Auth::user()->getAuthIdentifier();
        });
    }


    /**
     * @param $value
     */
    public function setNoticeTillAttribute($value)
    {
        $this->attributes['notice_till'] = Carbon::parse($value)->format('Y-m-d');
    }


    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [
        'notice_till' => "datetime:d M Y"
    ];

}
