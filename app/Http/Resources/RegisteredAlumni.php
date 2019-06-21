<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed image
 * @property mixed name
 * @property mixed email
 * @property mixed mobile
 * @property mixed programme
 * @property mixed branch
 * @property mixed passing
 * @property mixed organisation
 * @property mixed designation
 * @property mixed created_at
 * @property mixed verified
 * @property mixed batch
 */
class RegisteredAlumni extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "image" => $this->image ? $this->image->image : null,
            "name" => $this->name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "programme" => $this->programme,
            "branch" => $this->branch,
            "batch" => $this->batch,
            "passing" => $this->passing,
            "organisation" => $this->organisation,
            "designation" => $this->designation,
            'verified' => $this->verified,
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
