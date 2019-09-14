<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicNewsAndStories extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
//            'cover' => $this->cover,
            'cover_thumb' => $this->when($this->getMedia('cover')->last(), function () {
                return $this->getMedia('cover')->last()->getUrl('thumb');
            }),
            'description' => $this->description,
//            'content' => $this->content,
//            'social_link' => $this->social_link,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y'),
            $this->mergeWhen($this->published, [
                'published' => $this->published,
                'published_by' => $this->when($this->publisher && $this->published_by, function () {
                    return [
                        'name' => $this->publisher->name,
//                        'email' => $this->publisher->email,
//                        'mobile' => $this->publisher->mobile,
//                        'username' => $this->publisher->username,
//                        'is_alumni' => $this->publisher->is_alumni,
//                        'active' => $this->publisher->active,
                    ];
                }),
                'published_at' => Carbon::parse($this->published_at)->format('d M Y'),
            ]),
        ];
    }
}
