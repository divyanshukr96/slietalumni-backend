<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professional extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = ['organisation', 'org_address', 'org_contact', 'org_email', 'designation'];


    /**
     * @return MorphTo
     */
    public function professionalable()
    {
        return $this->morphTo();
    }

}
