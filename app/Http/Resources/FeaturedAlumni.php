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
        if ($this->alumni) {
            $data = [
                "registered" => true,
                'name' => $this->alumni['name'],
                'email' => $this->alumni['email'],
                'mobile' => $this->alumni['mobile'],
                $this->mergeWhen($this->alumni->professionals->first(), [
                    'organisation' => $this->alumni->professionals->first()['organisation'],
                    'designation' => $this->alumni->professionals->first()['designation'],
                ]),
            ];
        } else {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'organisation' => $this->organisation,
                'designation' => $this->designation,
            ];
        }

        return array_merge(['id' => $this->id], $data, [

            'image' => $this->image ? $this->image->getUrl() : $this->when($this->alumni, function () {
                return $this->alumni['profile'];
            }),

            'featured' => Carbon::parse($this->featured)->format('d M Y'),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ]);
    }
}
