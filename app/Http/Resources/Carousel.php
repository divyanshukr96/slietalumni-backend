<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed active
 * @property mixed created_at
 * @property mixed image
 */
class Carousel extends JsonResource
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
            "image_id" => "395b24ae-0066-45d3-a15f-0af212e4281c",
            'image' => $this->image->image,
            'image_url' => url($this->image->image),
            "active" => $this->active,
            "created_at" => Carbon::parse($this->created_at)->format('d M Y h:m'),
        ];
    }
}
