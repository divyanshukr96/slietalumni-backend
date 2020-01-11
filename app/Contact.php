<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @method static create(array $all)
 * @method static latest()
 */
class Contact extends Model implements Auditable
{
    use SoftDeletes, UsesUuid;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'email', 'subject', 'message'];


    protected $casts = [
        'status' => 'boolean',
    ];

}
