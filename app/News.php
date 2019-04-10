<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class News extends Model
{
    protected $fillable = ['heading', 'content'];


}
