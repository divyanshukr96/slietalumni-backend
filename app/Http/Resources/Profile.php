<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed username
 * @property mixed name
 * @property mixed email
 * @property mixed mobile
 * @property mixed active
 * @property mixed is_alumni
 * @property mixed id
 * @property mixed created_at
 * @property mixed academics
 * @property mixed professionals
 */
class Profile extends JsonResource
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
            "username" => $this->username,
            "name" => ucwords(strtolower($this->name)),
            "email" => $this->email,
            "mobile" => $this->mobile,
            "active" => $this->active,
            "is_alumni" => $this->is_alumni,
            'academics' => $this->academics,
            'professionals' => $this->professionals,
            "registered_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
