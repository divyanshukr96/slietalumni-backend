<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class AlumniDataCollection extends Model
{
    protected $fillable = ['name', 'email', 'mobile', 'programme', 'batch', 'branch', 'organisation'];

}
