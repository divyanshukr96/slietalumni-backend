<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed name
 * @property mixed email
 * @property mixed mobile
 * @property mixed username
 * @property mixed is_alumni
 * @property mixed id
 * @property mixed created_at
 * @property mixed active
 * @property mixed professionals
 */
class FeaturedAlumniSearch extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "username" => $this->username,
            "active" => $this->active,
            "is_alumni" => $this->is_alumni,
            'organisation' => $this->when($this->professionals, function () {
                return $this->professionals->first()['organisation'];
            }),
            'designation' => $this->when($this->professionals, function () {
                return $this->professionals->first()['designation'];
            }),

            $this->mergeWhen($this->getMedia('profile')->last(), [
                "image" => $this->getMedia('profile')->last()->getFullUrl(),
                "image_thumb" => $this->getMedia('profile')->last()->getFullUrl('thumb'),
            ]),

            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
