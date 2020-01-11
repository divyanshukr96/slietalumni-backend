<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed name
 * @property mixed designation
 * @property mixed from
 * @property mixed to
 * @property mixed sac
 * @property mixed created_at
 * @property mixed profile
 * @method getMedia(string $string)
 */
class Member extends JsonResource
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
            "user_id" => $this->user_id,
            "name" => $this->name,
            "designation" => $this->designation,
            "from" => $this->from,
            "to" => $this->to,
            "sac" => $this->sac,
            "image" => $this->when($this->getMedia('member')->last(), function () {
                return $this->getMedia('member')->last()->getFullUrl();
            }),
            "profile" => $this->when($this->profile, function () {
                return $this->profile->username;
            }),
            "created_at" => Carbon::parse($this->created_at)->format('d M Y'),
        ];
    }
}
