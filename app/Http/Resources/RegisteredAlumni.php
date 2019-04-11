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
            "id"=> $this->id,
            "image"=> $this->image->image,
            "name" => $this->name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "programme" => $this->programme,
            "branch" => $this->branch,
            "passing" => $this->passing,
            "organisation" => $this->organisation,
            "designation" => $this->designation,
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
