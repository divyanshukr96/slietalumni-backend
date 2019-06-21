<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed name
 * @property mixed email
 * @property mixed username
 * @property mixed mobile
 * @property mixed image
 */
class UserResource extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "username" => $this->username,
            "image" => $this->image ? $this->image->image : null,
            "mobile" => $this->mobile
        ];
    }
}
