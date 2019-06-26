<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed eventType
 * @property mixed description
 * @property mixed content
 * @property mixed venue
 * @property mixed date
 * @property mixed time
 * @property mixed created_at
 * @property mixed image
 * @property mixed published_by
 * @property mixed published_at
 */
class Event extends JsonResource
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
            'image' => $this->image ? $this->image->image : null,
            'image_thumb' => $this->image ? 'https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500' : null,
            'content' => $this->content,
            'venue' => $this->venue,
            'date' => Carbon::parse($this->date)->format('d M Y'),
            'time' => Carbon::parse($this->time)->format('H:i'),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
            $this->mergeWhen($this->published_by, [
                'published_by' => Str::ucfirst($this->published_by),
                'published_at' => Carbon::parse($this->published_at)->format('d M Y'),
            ]),
        ];
    }
}
