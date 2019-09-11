<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed image
 */
class PublicCarousel extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (!empty($this->image)) {
            return $this->image->getUrl();
        }
        return null;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'time' => Carbon::now()->format('d-m-Y H:i:s')
        ];
    }
}
