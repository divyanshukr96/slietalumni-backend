<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed album
 * @property mixed image
 * @property mixed width
 * @property mixed height
 * @property mixed created_at
 */
class GalleryImage extends JsonResource
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
            'album' => $this->album ? $this->album->title : null,
            $this->mergeWhen($this->image, [
                "image" => $this->image->getUrl(),
                'src' => $this->image->getUrl('thumb'),
                'width' => $this->width,
                'height' => $this->height,
            ]),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
