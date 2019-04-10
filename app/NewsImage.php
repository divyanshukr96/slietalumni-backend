<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{


    public function image()
    {
        $this->belongsTo('App\Image');
    }


}
