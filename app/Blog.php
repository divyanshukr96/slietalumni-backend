<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static create(array $all)
 */
class Blog extends Model implements HasMedia, Auditable
{
    use SoftDeletes, UsesUuid, HasMediaTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['title', 'content'];


}
