<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed mobile
 * @property mixed organisation
 * @property mixed designation
 * @property mixed category
 * @property mixed amount
 * @property mixed receipt
 * @property mixed user_id
 * @property mixed user
 * @property mixed created_at
 * @property mixed verified
 * @property mixed verified_by
 * @property mixed verified_at
 */
class Donation extends JsonResource
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
            "email" => $this->user ? $this->user['email'] : $this->email,
            "mobile" => $this->mobile ?: $this->user ? $this->user['mobile'] : null,
            "organisation" => $this->organisation,
            "designation" => $this->designation,
            "category" => $this->category,
            "amount" => $this->amount,
            "receipt" => $this->receipt,
            $this->mergeWhen($this->verified, [
                'verified' => $this->verified,
                'verified_by' => $this->verified_by,
                'verified_at' => Carbon::parse($this->verified_at)->format('d M Y'),
            ]),
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
