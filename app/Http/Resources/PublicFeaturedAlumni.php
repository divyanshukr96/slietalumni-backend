<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed name
 * @property mixed alumni
 * @property mixed designation
 * @property mixed image
 * @property mixed organisation
 */
class PublicFeaturedAlumni extends JsonResource
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
            'name' => $this->name ?: $this->when($this->alumni, function () {
                return $this->alumni->name;
            }),
            'image' => $this->image ? $this->image->getUrl('thumb') : $this->when($this->alumni, function () {
                return $this->alumni['profile_thumb'];
            }),
            'designation' => $this->designation ?: $this->when($this->alumni and $this->alumni->professionals, function () {
                return $this->alumni->professionals->first()['designation'];
            }),
            'organisation' => $this->organisation ?: $this->when($this->alumni and $this->alumni->professionals, function () {
                return $this->alumni->professionals->first()['organisation'];
            }),

        ];
    }
}
