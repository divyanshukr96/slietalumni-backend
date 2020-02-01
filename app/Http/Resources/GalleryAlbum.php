<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed description
 * @property mixed cover
 * @property mixed created_at
 * @property mixed images
 * @method images()
 */
class GalleryAlbum extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "cover" => $this->when($this->cover || $this->images->first(), function () {
                if (!$this->cover) {
                    return $this->images->first()->image->getUrl('thumb');
                }
                return $this->cover;
            }),
            "images" => GalleryImage::collection($this->images()->latest()->get()),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
