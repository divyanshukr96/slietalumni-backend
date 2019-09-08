<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static latest()
 */
class Contact extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = ['name', 'email', 'subject', 'message'];

}
