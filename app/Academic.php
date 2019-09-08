<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academic extends Model
{
    use SoftDeletes, UsesUuid;

    // enrollment is the enrolled year / year of registration
    protected $fillable = ['programme', 'branch', 'enrollment', 'passing', 'batch', 'registration', 'institute'];

    /**
     * @return BelongsTo
     */
    public function academicable()
    {
        return $this->morphTo();
    }

}
