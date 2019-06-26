<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed covers
 * @property mixed description
 * @property mixed social_link
 * @property mixed content
 * @property mixed created_at
 */
class News extends JsonResource
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
            'title' => $this->title,
            'cover' => $this->covers ? $this->covers->image : null,
            'cover_thumb' => "https://zos.alipayobjects.com/rmsportal/jkjgkEfvpUPVyRjUImniVslZfWPnJuuZ.png",
            'description' => $this->description,
            'social_link' => $this->social_link,
            'content' => $this->content,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y'),
        ];
    }
}
