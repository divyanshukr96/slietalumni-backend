<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academic extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = ['programme', 'branch', 'enrollment', 'passing', 'batch', 'registration', 'institute'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
