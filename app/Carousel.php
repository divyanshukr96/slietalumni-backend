<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereActive(bool $true)
 */
class Carousel extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = ['active'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
