<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @method static create(array $all)
 * @method static where(string $string, array $only)
 * @method static whereName(array $only)
 */
class EventType extends Model implements Auditable
{
    use UsesUuid, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'title', 'description'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
