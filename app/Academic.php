<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Academic extends Model implements Auditable
{
    use SoftDeletes, UsesUuid;
    use \OwenIt\Auditing\Auditable;

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
