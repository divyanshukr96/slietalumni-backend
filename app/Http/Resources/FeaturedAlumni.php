<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed alumni
 * @property mixed name
 * @property mixed email
 * @property mixed mobile
 * @property mixed organisation
 * @property mixed designation
 * @property mixed featured
 * @property mixed created_at
 * @property mixed image
 */
class FeaturedAlumni extends JsonResource
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
            'id' => $this->id,
            $this->mergeWhen(!$this->alumni, [
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'organisation' => $this->organisation,
                'designation' => $this->designation,
                'image' => $this->when($this->image, function () {
                    return $this->image->getUrl();
                }),
            ]),
            $this->mergeWhen($this->alumni, [
                'name' => $this->alumni['name'],
                'email' => $this->alumni['email'],
                'mobile' => $this->alumni['mobile'],
                'organisation' => $this->alumni['organisation'],
                'designation' => $this->alumni['designation'],
                'image' => $this->alumni['profile'],
            ]),

            'featured' => Carbon::parse($this->featured)->format('d M Y'),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
