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
 * @property mixed verified_at
 * @property mixed verified_by
 * @property mixed image_url
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
            "image" => $this->image->file_name,
            "image_url" => $this->image_url,
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
            'verified_at' => $this->when($this->verified and $this->verified_at, function () {
                return Carbon::parse($this->verified_at)->format('d M Y H:i');
            }),
            'verified_by' => $this->when($this->verified and $this->verified_by, function () {
                return [
                    'name' => $this->verified_by->name,
                    'email' => $this->verified_by->email,
                    'username' => $this->verified_by->username,
                    'active' => $this->verified_by->active,
                    'profile' => $this->verified_by->profile
                ];
            }),
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
