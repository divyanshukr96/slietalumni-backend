<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static where(string $string, array $only)
 */
class EventType extends Model
{
    use UsesUuid;

    protected $fillable = ['name', 'title', 'about'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
