<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use \Spatie\Permission\Models\Role as Model;
use Str;

/**
 * @method static latest()
 */
class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'display_name', 'description', 'guard_name'];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::lower($value);
    }

    /**
     * @param $value
     */
    public function setDisplayNameAttribute($value)
    {
        $this->attributes['display_name'] = ucwords($value);
    }

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucfirst($value);
    }

//    /**
//     * @param $value
//     * @return string
//     */
//    public function getNameAttribute($value)
//    {
//        return ucfirst($value);
//    }

}
