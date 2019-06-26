<?php

namespace App;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 */
class Event extends Model
{
    use UsesUuid, SoftDeletes;

    protected $fillable = ['title', 'description', 'venue', 'date', 'time', 'image_id', 'content'];

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setTimeAttribute($value)
    {
        $this->attributes['time'] = Carbon::parse($value)->format('H:i');
    }

}
