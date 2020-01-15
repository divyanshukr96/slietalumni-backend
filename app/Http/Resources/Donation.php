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
 * @property mixed verifyBy
 * @property mixed confirm_amount
 * @property mixed description
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
            "confirm_amount" => $this->when($this->confirm_amount, function () {
                return $this->confirm_amount;
            }),
            "receipt" => $this->receipt,
            "description" => $this->when($this->description, function () {
                return $this->description;
            }),
            $this->mergeWhen($this->verified, [
                'verified' => $this->verified,
                'verified_by' => $this->when($this->verifyBy, function () {
                    return $this->verifyBy->name;
                }),
                'verified_at' => Carbon::parse($this->verified_at)->format('d M Y'),
            ]),
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
