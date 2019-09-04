<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static find($id)
 * @method static findOrFail($id)
 */
class DataCollection extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = ['name', 'email', 'mobile', 'programme', 'batch', 'branch', 'passing', 'organisation', 'designation'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderCreate', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(preg_replace('/\s+/', ' ', $value));
    }

}
