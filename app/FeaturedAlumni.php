<?php

namespace App;

use App\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static latest()
 * @method static create(array $validated)
 */
class FeaturedAlumni extends Model
{
    use UsesUuid, SoftDeletes;

    protected $fillable = ['name', 'email', 'mobile', 'organisation', 'designation', 'image', 'featured'];


    public function alumni()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @param $value
     */
    public function setImageAttribute($value)
    {
        if (is_object($value)) $this->attributes['image_id'] = Image::create(['image' => $value])->id;
    }

    /**
     * @param $value
     */
    public function setFeaturedAttribute($value)
    {
        $this->attributes['featured'] = Carbon::parse($value)->format('Y-m-d');
    }

}
