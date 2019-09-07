<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed email
 * @property mixed mobile
 * @property mixed created_at
 * @property mixed programme
 * @property mixed batch
 * @property mixed branch
 * @property mixed passing
 * @property mixed organisation
 * @property mixed designation
 * @property mixed academic
 * @property mixed professional
 * @property mixed image
 */
class DataCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->email,
            'mobile' => $this->mobile,

            // Academic Details Here
            'programme' => $this->when($this->academic, function () {
                return $this->academic->programme;
            }),
            'batch' => $this->when($this->academic, function () {
                return $this->academic->batch;
            }),
            'branch' => $this->when($this->academic, function () {
                return $this->academic->branch;
            }),
            'passing' => $this->when($this->academic, function () {
                return $this->academic->passing;
            }),

            // Professional Details Here
            'organisation' => $this->when($this->professional, function () {
                return $this->professional->organisation;
            }),
            'designation' => $this->when($this->professional, function () {
                return $this->professional->designation;
            }),

            //  Profile Image here
            'image' => $this->when($this->image, function () {
                return $this->image->file_name;
            }),
            'image_url' => $this->when($this->image, function () {
                return $this->image->getUrl();
            }),


            "created_at" => Carbon::parse($this->created_at)->format('d M Y h:m'),
        ];
    }
}
