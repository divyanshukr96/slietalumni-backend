<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static where(string $string, array $only)
 * @method static whereName(array $only)
 */
class EventType extends Model
{
    use UsesUuid, SoftDeletes;

    protected $fillable = ['name', 'title', 'description'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
