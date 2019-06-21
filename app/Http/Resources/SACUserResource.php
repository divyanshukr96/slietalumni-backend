<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SACUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'username' => $this->username,
            'image' => $this->photo,
            'roles' => $this->getRoleNames(),
            'active' => $this->active,
            'created_at' =>  Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
    }
}
