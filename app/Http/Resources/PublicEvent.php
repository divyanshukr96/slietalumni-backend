<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed eventType
 * @property mixed description
 * @property mixed image
 * @property mixed content
 * @property mixed venue
 * @property mixed date
 * @property mixed time
 * @property mixed published
 * @property mixed published_by
 * @property mixed published_at
 * @method getMedia()
 */
class PublicEvent extends JsonResource
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
            'event' => $this->eventType->name,
            'event_type' => $this->eventType->title,
            'description' => $this->description,
            'image' => $this->image,
            'image_thumb' => $this->when($this->getMedia()->last(), function () {
                return $this->getMedia()->last()->getUrl('card');
            }),
            'content' => $this->content,
            'venue' => $this->venue,
            'date' => $this->when($this->date, function () {
                return Carbon::parse($this->date)->format('D M d Y');
            }),
            'time' => $this->when($this->time, function () {
                return Carbon::parse($this->time)->format('H:i');
            }),

            $this->mergeWhen($this->published, [
                'published' => $this->published,
                'published_by' => $this->published_by,
                'published_at' => Carbon::parse($this->published_at)->format('d M Y'),
            ]),
        ];
    }
}
