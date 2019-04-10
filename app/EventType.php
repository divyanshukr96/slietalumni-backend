<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static where(string $string, array $only)
 */
class EventType extends Model
{
    protected $fillable = ['name', 'title', 'about'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
