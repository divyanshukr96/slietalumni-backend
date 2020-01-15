<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed user
 * @property mixed name
 * @property mixed organisation
 * @property mixed designation
 * @property mixed category
 * @property mixed created_at
 */
class PublicDonation extends JsonResource
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
            "is_member" => $this->user ? true : false,
            "name" => $this->user ? $this->user['name'] : $this->name,
            "organisation" => $this->organisation,
            "designation" => $this->designation,
            "category" => $this->category,
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
