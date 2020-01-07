<?php

namespace App;


use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\Models\Media as Model;

class Media extends Model implements Auditable
{
    use SoftDeletes, UsesUuid;
    use \OwenIt\Auditing\Auditable;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = auth()->user();
            if ($user) $model->user_id = $user->getAuthIdentifier();
        });
    }

}
