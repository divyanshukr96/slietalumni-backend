<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @method static create(array $all)
 */
class Blog extends Model implements HasMedia
{
    use SoftDeletes, UsesUuid, HasMediaTrait;

    protected $fillable = ['title', 'content'];


}
