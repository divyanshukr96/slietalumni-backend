<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed name
 * @property mixed email
 * @property mixed designation
 * @property mixed mobile
 * @property mixed programme
 * @property mixed branch
 * @property mixed passing
 * @property mixed organisation
 * @property mixed batch
 */
class AlumniRegisterResource extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "programme" => $this->programme,
            "branch" => $this->branch,
            "batch" => $this->batch,
            "passing" => $this->passing,
            "organisation" => $this->organisation,
            "designation" => $this->designation
        ];
    }
}
