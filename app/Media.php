<?php

namespace App;


use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\Models\Media as Model;

class Media extends Model
{
    use SoftDeletes, UsesUuid;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = auth()->user();
            if ($user) $model->user_id = $user->getAuthIdentifier();
        });
    }

}
