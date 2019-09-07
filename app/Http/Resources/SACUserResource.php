<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed mobile
 * @property mixed username
 * @property mixed photo
 * @property mixed active
 * @property mixed created_at
 * @property mixed profile
 * @method getRoleNames()
 * @method getAllPermissions()
 */
class SACUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'username' => $this->username,
            'image' => $this->photo,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->map(function ($data) {
                return $data->name;
            }),
            'profile' => $this->profile,
            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i'),
        ];
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
